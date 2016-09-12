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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Location Type encoder
 */
class LocationEncoder {

	/**
	 * Encode to JSON the given objects.
	 *
	 * @param QueryResultInterface|array $locations
	 * @param $contentElementUid integer UID of the content element with the map container
	 * @return string
	 */
	public function encode($locations, $contentElementUid) {

		$collectedObjects = array();

		foreach ($locations as $location) {
			$collectedObjects[] = array(
				'id' => $location['uid'],
				'latitude' => $location['latitude'] - 0,
				'longitude' => $location['longitude'] - 0,
				'type' => (int)$location['location_type'],
				'active' => $this->getLocationService($location)->isActive($contentElementUid),
				'hasEvent' => $location['events'] > 0
			);
		}
		return json_encode($collectedObjects);
	}

	/**
	 * @param array $location
	 * @return \Visol\EasyvoteLocation\Service\LocationService
	 */
	public function getLocationService(array $location){
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\Service\LocationService', $location);
	}
}