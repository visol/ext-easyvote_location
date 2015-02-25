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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
	 * @return void
	 */
	public function listAction() {
		$locations = $this->locationRepository->findAllForMaps();
		$encodedLocations = $this->getLocationEncoder()->encode($locations);
		$this->view->assign('value', $encodedLocations);
	}

	/**
	 * @return LocationEncoder
	 */
	protected function getLocationEncoder() {
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\JsonEncoder\LocationEncoder');
	}
}