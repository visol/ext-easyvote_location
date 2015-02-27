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

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * LocationController
 */
class LocationController extends ActionController {

	/**
	 * @var \Visol\EasyvoteLocation\Domain\Repository\LocationRepository
	 * @inject
	 */
	protected $locationRepository = NULL;

	/**
	 * @var \Visol\EasyvoteLocation\Domain\Repository\LocationTypeRepository
	 * @inject
	 */
	protected $locationTypeRepository = NULL;

	/**
	 * @return void
	 */
	public function indexAction() {
		$locations = $this->locationRepository->findAll();
		$locationTypes = $this->locationTypeRepository->findAll();

		$this->view->assign('locations', $locations);
		$this->view->assign('locationTypes', $locationTypes);
	}

	/**
	 * @return void
	 */
	public function searchAction() {
		$this->view->assign('settings', $this->getGlobalSettings());
	}

	/**
	 * @return array
	 */
	protected function getGlobalSettings(){
		return $this->getFrontendObject()->tmpl->setup['plugin.']['tx_easyvote.']['settings.'];
	}

	/**
	 * Returns an instance of the Frontend object.
	 *
	 * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	protected function getFrontendObject() {
		return $GLOBALS['TSFE'];
	}

}