<?php
namespace Visol\EasyvoteLocation\ViewHelpers\Maps;

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
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use Visol\EasyvoteLocation\JsonEncoder\JsonEncoderInterface;

/**
 * View helper for encoding a set of objects to JSON.
 */
class CoordinateViewHelper extends AbstractViewHelper {

	/**
	 * @var float
	 */
	protected $defaultLongitude = 8.2242101;

	/**
	 * @var float
	 */
	protected $defaultLatitude = 46.8131873;

	/**
	 * Encode a set of objects to JSON
	 *
	 * @param string $type correspond to longitude or latitude
	 * @return string
	 */
	public function render($type) {

		// Default value.
		$property = 'default' . ucfirst($type);
		$point = $this->$property;

		// Override coordinate if User is logged in.
		if ($this->getUserService()->isAuthenticated()) {
			$city = $this->getUserService()->getAuthenticatedUser()->getCitySelection();

			// Fetch the Latitude & Longitude of the city.
			if ($city) {
				$point = ObjectAccess::getProperty($city, $type);
			}
		}

		return sprintf(
			'EasyVote.%s = %s;',
			ucfirst($type),
			$point
		);
	}

	/**
	 * @return \Visol\EasyvoteLocation\Service\UserService
	 */
	public function getUserService() {
		return $this->objectManager->get('Visol\EasyvoteLocation\Service\UserService');
	}

}
