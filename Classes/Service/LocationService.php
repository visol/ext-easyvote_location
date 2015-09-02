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
 * Service related to the Location
 */
class LocationService {

	/**
	 * @var array
	 */
	protected $location = array();

	/**
	 * Constructor
	 *
	 * @param mixed $location
	 */
	public function __construct($location) {
		if ($location instanceof Location) {
			$location = $location->toArray();
		}
		$this->location = $location;
	}

	/**
	 * @return bool
	 */
	public function isActive() {

		$isActive = TRUE;
		$votingLimit = $this->getVotingDayService()->getTimeLimit();
		$locationType = (int)$this->location['location_type'];

		if (!$votingLimit) {
			$isActive = FALSE;
		} elseif ($locationType === LocationType::TYPE_POST_BOX) {
			$isActive = $this->isActiveForPostBox($votingLimit);
		} else {
			// @todo
		}
		return $isActive;
	}

	/**
	 * @return bool
	 */
	public function isPostBActive() {
		$isActive = TRUE;
		$votingLimit = $this->getVotingDayService()->getTimeLimit();
		$locationType = (int)$this->location['location_type'];

		if (!$votingLimit) {
			$isActive = FALSE;
		} elseif ($locationType === LocationType::TYPE_POST_BOX) {
			$isActive = $this->isActiveForPostBox($votingLimit, DAY::WEDNESDAY, 4);
		}
		return $isActive;
	}

	/**
	 * @param int $votingLimit
	 * @param string $day
	 * @param int $dayBack
	 * @return bool
	 */
	protected function isActiveForPostBox($votingLimit, $day = DAY::THURSDAY, $dayBack = 3) {
		$day4 = explode(':', $this->location['emptying_time_day_' . $day]); // typical value 19:00:00
		$hour = $day4[0] * Time::HOUR;
		$minute = $day4[1] * Time::MINUTE;
		$day4Time = Time::DAY - $hour + $minute; // delta time to be removed between midnight and emptying time.

		// 3 corresponds to 3 days as from Sunday midnight.
		$votingLimit = $votingLimit - (Time::DAY * $dayBack) - $day4Time;
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
