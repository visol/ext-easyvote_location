<?php
namespace Visol\EasyvoteLocation\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Cache\Cache;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Visol\EasyvoteLocation\DataFormatter\LocationFormatter;
use Visol\EasyvoteLocation\Domain\Model\Location;
use Visol\EasyvoteLocation\JsonEncoder\LocationEncoder;

/**
 * LocationController
 */
class LocationApiController extends ActionController {

	/**
	 * @var string
	 */
	protected $defaultViewObjectName = 'TYPO3\CMS\Extbase\Mvc\View\JsonView';

	/**
	 * @var \Visol\EasyvoteLocation\Domain\Repository\LocationRepository
	 * @inject
	 */
	protected $locationRepository = NULL;

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
	 */
	protected $cacheInstance;

	/**
	 * @return string
	 */
	public function listAction() {
		$this->initializeCache();

		$cacheIdentifier = 'locations';
		$response = $this->cacheInstance->get($cacheIdentifier);

		if (!$response) {

			$locations = $this->locationRepository->findAllForMaps();
			$response = $this->getLocationEncoder()->encode($locations);

			$tags = array();
			$lifetime = '600'; // @todo fine a good interval. It could depends on the time of the day.
			$this->cacheInstance->set($cacheIdentifier, $response, $tags, $lifetime);
		}

		$this->response->setHeader('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @param Location $location
	 * @return string
	 */
	public function showAction(Location $location) {
		$this->view->assign('value', $this->getLocationFormatter()->format($location));
	}

	/**
	 * @return LocationEncoder
	 */
	protected function getLocationEncoder() {
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\JsonEncoder\LocationEncoder');
	}

	/**
	 * @return LocationFormatter
	 */
	protected function getLocationFormatter() {
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\DataFormatter\LocationFormatter');
	}

	/**
	 * Initialize cache instance to be ready to use
	 *
	 * @return void
	 */
	protected function initializeCache() {
		Cache::initializeCachingFramework();
		try {
			$this->cacheInstance = $this->getCacheManager()->getCache('easyvote_location');
		} catch (NoSuchCacheException $e) {
			$this->cacheInstance = $this->getCacheFactory()->create(
				'easyvote_location',
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location']['frontend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location']['backend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location']['options']
			);
		}
	}

	/**
	 * Return the Cache Manager
	 *
	 * @return \TYPO3\CMS\Core\Cache\CacheManager
	 */
	protected function getCacheManager() {
		return GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager');
	}

	/**
	 * Return the Cache Factory
	 *
	 * @return \TYPO3\CMS\Core\Cache\CacheFactory
	 */
	protected function getCacheFactory() {
		return $GLOBALS['typo3CacheFactory'];
	}

}