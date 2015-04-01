<?php
namespace Visol\EasyvoteLocation\ViewHelpers\Format\PostBox;

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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use Visol\EasyvoteLocation\Service\Time;
use Visol\EasyvoteLocation\Service\VotingDayService;

/**
 * View helper which render a limit date for a post box
 */
class DateViewHelper extends AbstractViewHelper {

	/**
	 * @param int $dayBack
	 * @return string
	 */
	public function render($dayBack) {
		return date('d.m.Y', $this->getVotingDayService()->getTimeLimit() - ($dayBack * Time::DAY));
	}

	/**
	 * @return VotingDayService
	 */
	protected function getVotingDayService() {
		return GeneralUtility::makeInstance(VotingDayService::class);
	}

}
