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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use Visol\EasyvoteLocation\JsonEncoder\JsonEncoderInterface;

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

		$dataEncoder = $this->getAppropriateJsonEncoder($type);
		$encodedObjects = $dataEncoder->encode($objects);

		return sprintf(
			'EasyvoteLocation.%s = %s;',
			ucfirst($type). 's', // Add ending "s" for the plural. Works so far...
			$encodedObjects
		);
	}

	/**
	 * @param string $type
	 * @return JsonEncoderInterface
	 */
	protected function getAppropriateJsonEncoder($type){
		$className = sprintf(
			'Visol\EasyvoteLocation\JsonEncoder\%sEncoder',
			ucfirst($type)
		);

		if (! class_exists($className)) {
			throw new \RuntimeException('I could not find class ' . $className, 1424774501);
		}
		return GeneralUtility::makeInstance($className);
	}

}
