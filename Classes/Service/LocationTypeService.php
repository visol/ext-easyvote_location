<?php
namespace Visol\EasyvoteLocation\Service;

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
use Visol\EasyvoteLocation\Domain\Model\Location;
use Visol\EasyvoteLocation\Domain\Model\LocationType;
use Visol\EasyvoteLocation\Enumeration\Day;
use Visol\EasyvoteLocation\Enumeration\Time;

/**
 * Service related to the LocationType
 */
class LocationTypeService {

	/**
	 * @param LocationType $locationType
	 * @return string
	 */
	public function getIcon(LocationType $locationType) {
		$icon = '';
		if ($locationType->getUid() === LocationType::TYPE_POST_BOX) {
			$icon = 'PostBox.png';
		} elseif ($locationType->getUid() === LocationType::TYPE_MUNICIPAL_ADMINISTRATION) {
			$icon = 'MunicipalAdministration.png';
		} elseif ($locationType->getUid() === LocationType::TYPE_POLLING_STATION) {
			$icon = 'PollingStation.png';
		} elseif ($locationType->getUid() === LocationType::TYPE_VOTENOW2015) {
			$icon = 'VoteNow2015.png';
		}
		return $icon;
	}

}
