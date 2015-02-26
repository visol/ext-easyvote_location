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

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Location Type encoder
 */
class LocationEncoder implements JsonEncoderInterface {

	/**
	 * Encode to JSON the given objects.
	 *
	 * @param QueryResultInterface|array $locations
	 * @return string
	 */
	public function encode($locations){

		$collectedObjects = array();

		foreach ($locations as $location) {

			$collectedObjects[] = array(
				'name' => $location['name'],
				'latitude' => $location['latitude'] - 0,
				'longitude' => $location['longitude'] - 0,
				'type' => $location['location_type'],
				'description'=> $location['description'],
			);
		}

		return json_encode($collectedObjects);
	}

}