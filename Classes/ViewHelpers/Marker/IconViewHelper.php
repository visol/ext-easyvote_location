<?php
namespace Visol\EasyvoteLocation\ViewHelpers\Marker;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use Visol\EasyvoteLocation\Domain\Model\Location;

/**
 * View helper for encoding a set of objects to JSON.
 */
class IconViewHelper extends AbstractViewHelper {

	/**
	 * @return string
	 */
	public function render() {

		/** @var Location $location */
		$location = $this->templateVariableContainer->get('location');
		$extensionPath = ExtensionManagementUtility::siteRelPath('easyvote_location');
		return sprintf('%sResources/Public/Icons/PostBox%s.png',
			$extensionPath,
			$location->getIsActive() ? '' : 'Gray'
		);
	}

}
