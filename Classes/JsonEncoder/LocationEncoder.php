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
use Visol\EasyvoteLocation\Domain\Model\LocationType;
use Visol\EasyvoteLocation\Service\Time;
use Visol\EasyvoteLocation\Service\VotingDayService;

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
	public function encode($locations) {

		$collectedObjects = array();

		foreach ($locations as $location) {
			$collectedObjects[] = array(
				'id' => $location['uid'],
				'latitude' => $location['latitude'] - 0,
				'longitude' => $location['longitude'] - 0,
				'type' => (int)$location['location_type'],
				'active' => $this->isActive($location),
			);
		}
		return json_encode($collectedObjects);
	}

	/**
	 * @param array $location
	 * @return bool
	 */
	protected function isActive($location) {

		$isActive = TRUE;
		$votingLimit = $this->getVotingDayService()->getTimeLimit();
		$locationType = (int)$location['location_type'];

		if (!$votingLimit) {
			$isActive = FALSE;
		} elseif ($locationType === LocationType::TYPE_POST_BOX) {
			$isActive = $this->isActiveForPostBox($location, $votingLimit);
		} else {
			// @todo
		}
		return $isActive;
	}

	/**
	 * @param array $location
	 * @param int $votingLimit
	 * @return bool
	 */
	protected function isActiveForPostBox(array $location, $votingLimit) {
		$day4 = explode(':', $location['emptying_time_day_4']); // typical value 19:00:00
		$hour = $day4[0] * Time::HOUR;
		$minute = $day4[1] * Time::MINUTE;
		$day4Time = Time::DAY - $hour + $minute; // delta time to be removed between midnight and emptying time.

		// 3 corresponds to 3 days as from Sunday midnight.
		$votingLimit = $votingLimit - (Time::DAY * 3) - $day4Time;
		return $votingLimit > $this->getCurrentTime();
	}

	/**
	 * @return int
	 */
	protected function getCurrentTime() {
		return time();
	}

	/**
	 * @return VotingDayService
	 */
	protected function getVotingDayService() {
		return GeneralUtility::makeInstance(VotingDayService::class);
	}

}