<?php
namespace Visol\EasyvoteLocation\ViewHelpers\ResultSet;

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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use Visol\EasyvoteLocation\Domain\Model\LocationType;

/**
 * View helper for encoding a set of objects to JSON.
 */
class ToJsonViewHelper extends AbstractViewHelper {

	/**
	 * Encode a set of objects to JSON
	 *
	 * @param QueryResult $objects
	 * @param string $type
	 * @return string
	 */
	public function render(QueryResult $objects, $type) {

		$output = '';
		if ($type == 'locationType') {
			$collectedObjects = array();
			/** @var LocationType $object */
			foreach ($objects as $object) {

				$collectedObjects[$object->getUid()] = array(
					'name' => $object->getName(),
					'icon' => 'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png',
				);
			}

			$output = sprintf(
				$this->getTemplate(),
				'LocationTypes',
				json_encode($collectedObjects)
			);

		}
		return $output;

	}

	/**
	 *
	 */
	protected function getTemplate() {
		return "
<script>
window.EV = {};
EV.%s = %s;
</script>
		";

	}
}
