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

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Visol\Easyvote\Domain\Model\VotingDay;

/**
 * Service related to the User.
 */
class VotingDayService implements SingletonInterface {

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
	 * @return bool
	 */
	public function getTimeLimit() {
		if (is_null($this->votingLimit)) {

			if ($this->hasOverrideByContentElement()) {
				$this->votingLimit = $this->getVotingLimitFromContentElement();
			} elseif ($this->hasVotingDay()) {
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
		return $this->votingDay->getVotingDate()->getTimestamp() + Time::DAY; // midnight
	}

	/**
	 * @return bool
	 */
	protected function getVotingLimitFromContentElement() {
		return $this->contentElementValue + Time::DAY; // midnight
	}

	/**
	 * @return bool
	 */
	protected function hasOverrideByContentElement() {
		// @todo constants

		$settings = $this->getSettings();
		$record = $this->getDatabaseConnection()->exec_SELECTgetSingleRow('uid, pi_flexform', 'tt_content', 'uid = ' . $settings['content_element_map_uid']);
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

	/**
	 * @return mixed
	 */
	public function getSettings() {
		return $this->getFrontendObject()->tmpl->setup['plugin.']['tx_easyvotelocation.']['settings.'];
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
