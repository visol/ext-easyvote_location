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
use Visol\Easyvote\Domain\Model\VotingDay;

/**
 * Location Type encoder
 */
class LocationEncoder implements JsonEncoderInterface {

	/**
	 * @var int
	 */
	protected $votingLimit;

	/**
	 * @var VotingDay
	 */
	protected $votingDay;

	/**
	 * @var int
	 */
	protected $contentElementValue;

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
		$votingLimit = $this->getVotingLimit();
		$locationType = (int)$location['location_type'];

		if (!$votingLimit) {
			$isActive = FALSE;
		} elseif ($locationType === 1) {

			$day4 = explode(':', $location['emptying_time_day_4']); // typical value 19:00:00
			$hour = $day4[0] * 3600;
			$minute = $day4[1] * 60;
			$day4Time = 86400 - $hour + $minute; // delta time to be removed between midnight and emptying time.

			// 3 corresponds to 3 days as from Sunday midnight.
			$votingLimit = $votingLimit - (86400 * 3) - $day4Time;
			$isActive = $votingLimit > time();
		} else {
			// @todo
		}
		return $isActive;
	}

	/**
	 * @return bool
	 */
	protected function getVotingLimit() {
		if (is_null($this->votingLimit)) {

			if ($this->hasOverrideByContentElement()) {
				$this->votingLimit = $this->getVotingLimitFromContentElement();
			} elseif($this->hasVotingDay()) {
				$this->votingLimit = $this->getVotingLimitFromVotingDay();
			} else {
				$this->votingLimit = 0;
			}
		}

		return $this->votingLimit;
	}

	/**
	 * @return bool
	 */
	protected function hasVotingDay() {
		$this->votingDay = $this->getVotingDayRepository()->findNextVotingDay();
		return !empty($this->votingDay);
	}

	/**
	 * @return int
	 */
	protected function getVotingLimitFromVotingDay() {
		return $this->votingDay->getVotingDate()->getTimestamp() + 86400 - 1;
	}

	/**
	 * @return bool
	 */
	protected function getVotingLimitFromContentElement() {
		return $this->contentElementValue + 86400 - 1; // 23:59
	}

	/**
	 * @return bool
	 */
	protected function hasOverrideByContentElement() {
		$record = $this->getDatabaseConnection()->exec_SELECTgetSingleRow('uid, pi_flexform', 'tt_content', 'uid = ' . 2617);
		if ($record) {
			$data = GeneralUtility::xml2array($record['pi_flexform']);

			if (!empty($data['data']['sDEF']['lDEF']['settings.nextVotingDay']['vDEF'])) {
				$this->contentElementValue = (int)$data['data']['sDEF']['lDEF']['settings.nextVotingDay']['vDEF'];
			}
		}

		return !is_null($this->contentElementValue);
	}

	/**
	 * @return \Visol\Easyvote\Domain\Repository\VotingDayRepository
	 */
	protected function getVotingDayRepository() {
		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		return $objectManager->get('Visol\Easyvote\Domain\Repository\VotingDayRepository');
	}

	/**
	 * Returns a pointer to the database.
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

}