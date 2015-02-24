<?php
namespace Visol\EasyvoteLocation\Command;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * Command Controller which imports the Postal Box as voting location.
 */
class PostBoxCommandController extends CommandController {

	/**
	 * @var string
	 */
	protected $tableName = 'tx_easyvotelocation_domain_model_location';

	/**
	 * Import the Postal Box as voting Location.
	 *
	 * @param string $file the path to the XML file containing the Postal Boxes.
	 * @return void
	 */
	public function importCommand($file) {

		$xml = simplexml_load_file($file) or die("Error: Cannot create object");

		$counter = 0;
		foreach ($xml->POI as $poi) {

			if (!$this->poiExists($poi)) {
				$this->createPoi($poi);
			}

			$this->updatePoi($poi);
			$counter++;
		}

		$message = sprintf('Imported %s Post Boxes', $counter);
		$this->output($message);
	}

	/**
	 * @param \SimpleXMLElement $poi
	 * @return bool
	 */
	protected function poiExists(\SimpleXMLElement $poi) {

		$clause = sprintf('import_id = "%s"', $poi['Id']);
		$clause .= BackendUtility::deleteClause($this->tableName);

		$record = $this->getDatabaseConnection()->exec_SELECTgetSingleRow('uid', $this->tableName, $clause);
		return !empty($record);
	}

	/**
	 * @param \SimpleXMLElement $poi
	 * @return bool
	 */
	protected function createPoi(\SimpleXMLElement $poi) {
		$this->getDatabaseConnection()->exec_INSERTquery($this->tableName, array('import_id' => $poi['Id']));
	}

	/**
	 * @param \SimpleXMLElement $poi
	 * @return bool
	 */
	protected function updatePoi(\SimpleXMLElement $poi) {
		$values = array(
			'location_type' => '1',
			'street' => (string)$poi->Address->Street,
			'zip' => (string)$poi->Address->Zip,
			'city' => (string)$poi->Address->City,
		);

		foreach ($poi->GeoLocation as $geoLocation) {
			$values['latitude'] = (string)$geoLocation->CoordinateLat;
			$values['longitude'] = (string)$geoLocation->CoordinateLng;
		}

		if (isset($poi->Description[0])) {
			$values['description'] = (string)$poi->Description[0];
		}

		foreach ($poi->Product->Deadline as $deadLine) {
			$values['emptying_time_day_' . $deadLine->Day] = (string)$deadLine->LatestTime;
		}

		$clause = sprintf('import_id = "%s"', $poi['Id']);
		$clause .= BackendUtility::deleteClause($this->tableName);
		$this->getDatabaseConnection()->exec_UPDATEquery($this->tableName, $clause, $values);
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
