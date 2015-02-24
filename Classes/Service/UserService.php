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
use Visol\Easyvote\Domain\Model\CommunityUser;

/**
 * Service related to the User.
 */
class UserService implements SingletonInterface {

	/**
	 * @var \Visol\Easyvote\Domain\Repository\CommunityUserRepository
	 * @inject
	 */
	protected $communityUserRepository;

	/**
	 * @return bool
	 */
	public function isAuthenticated() {
		return !empty($this->getFrontendUser()->user);
	}

	/**
	 * Returns an instance of the current Frontend User.
	 *
	 * @return \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
	 */
	protected function getFrontendUser() {
		return $GLOBALS['TSFE']->fe_user;
	}

	/**
	 * Returns an instance of the current Frontend User.
	 *
	 * @return CommunityUser
	 */
	public function getAuthenticatedUser() {
		$userData = $this->getUserData();
		return $this->communityUserRepository->findByUid($userData['uid']);
	}

	/**
	 * @return array
	 */
	public function getUserData() {
		$userData = $this->getFrontendUser()->user;
		return $this->isAuthenticated() ? $userData : array();
	}
}
