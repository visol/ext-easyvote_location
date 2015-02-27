<?php
namespace Visol\EasyvoteLocation\ViewHelpers;

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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper which encapsulates the Google Maps code
 */
class MapsViewHelper extends AbstractViewHelper {

	/**
	 * @return string
	 */
	public function render() {

		$output = sprintf(
			$this->getRawCode(),
			$this->renderChildren()
		);

		return $output;
	}

	/**
	 * @return string
	 */
	protected function getRawCode() {
		return "
<script>
if (typeof EasyVote !== 'object') {
	window.EasyVote = {}
}
%s
</script>
		";
	}

}
