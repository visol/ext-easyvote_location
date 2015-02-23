<?php
namespace Visol\EasyvoteLocation\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * LocationType
 */
class LocationType extends AbstractValueObject {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * icon
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $icon = NULL;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * isContentEditable
	 *
	 * @var boolean
	 */
	protected $isContentEditable = FALSE;

	/**
	 * locations
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Visol\EasyvoteLocation\Domain\Model\Location>
	 * @cascade remove
	 */
	protected $locations = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->locations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the icon
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets the icon
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
	 * @return void
	 */
	public function setIcon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the isContentEditable
	 *
	 * @return boolean $isContentEditable
	 */
	public function getIsContentEditable() {
		return $this->isContentEditable;
	}

	/**
	 * Sets the isContentEditable
	 *
	 * @param boolean $isContentEditable
	 * @return void
	 */
	public function setIsContentEditable($isContentEditable) {
		$this->isContentEditable = $isContentEditable;
	}

	/**
	 * Returns the boolean state of isContentEditable
	 *
	 * @return boolean
	 */
	public function isIsContentEditable() {
		return $this->isContentEditable;
	}

	/**
	 * Adds a Location
	 *
	 * @param \Visol\EasyvoteLocation\Domain\Model\Location $location
	 * @return void
	 */
	public function addLocation(\Visol\EasyvoteLocation\Domain\Model\Location $location) {
		$this->locations->attach($location);
	}

	/**
	 * Removes a Location
	 *
	 * @param \Visol\EasyvoteLocation\Domain\Model\Location $locationToRemove The Location to be removed
	 * @return void
	 */
	public function removeLocation(\Visol\EasyvoteLocation\Domain\Model\Location $locationToRemove) {
		$this->locations->detach($locationToRemove);
	}

	/**
	 * Returns the locations
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Visol\EasyvoteLocation\Domain\Model\Location> $locations
	 */
	public function getLocations() {
		return $this->locations;
	}

	/**
	 * Sets the locations
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Visol\EasyvoteLocation\Domain\Model\Location> $locations
	 * @return void
	 */
	public function setLocations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $locations) {
		$this->locations = $locations;
	}

}