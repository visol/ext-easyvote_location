<?php
namespace Visol\EasyvoteLocation\Domain\Repository;

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

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Locations
 */
class LocationRepository extends Repository {

	/**
	 * Initialize Repository
	 */
	public function initializeObject() {
		$querySettings = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($querySettings);
	}

	/**
	 * A more performing query than the $query
	 *
	 * @return array
	 */
	public function findAllForMaps() {

		$tableName = 'tx_easyvotelocation_domain_model_location';
		$clause = '1=1';
		$clause .= $this->getPageRepository()->enableFields($tableName);
		$clause .= $this->getPageRepository()->deleteClause($tableName);
		$records = $this->getDatabaseConnection()->exec_SELECTgetRows('*', $tableName, $clause);

		return $records;
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
	 * Returns an instance of the page repository.
	 *
	 * @return \TYPO3\CMS\Frontend\Page\PageRepository
	 */
	protected function getPageRepository() {
		return $GLOBALS['TSFE']->sys_page;
	}

}