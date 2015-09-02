<?php
namespace Visol\EasyvoteLocation\JsonEncoder;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Visol\EasyvoteLocation\Domain\Model\LocationType;

/**
 * Location Type encoder
 */
class LocationTypeEncoder implements JsonEncoderInterface {

	/**
	 * Encode to JSON the given objects.
	 *
	 * @param QueryResultInterface|array $objects
	 * @return string
	 */
	public function encode($objects){

		$collectedObjects = array();
		/** @var LocationType $object */
		foreach ($objects as $object) {

			$collectedObjects[$object->getUid()] = array(
				'name' => $object->getName(),
				'icon' => $this->getBasePath() . $this->getLocationTypeService()->getIcon($object),
			);
		}

		return json_encode($collectedObjects);
	}

	/**
	 * @return string
	 */
	protected function getBasePath() {
		return '/' . ExtensionManagementUtility::siteRelPath('easyvote_location') . 'Resources/Public/Icons/';
	}

	/**
	 * @return \Visol\EasyvoteLocation\Service\LocationTypeService
	 */
	public function getLocationTypeService(){
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\Service\LocationTypeService');
	}

}