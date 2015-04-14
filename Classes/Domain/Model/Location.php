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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Location
 */
class Location extends AbstractEntity {

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var string
	 */
	protected $address = '';

	/**
	 * @var float
	 */
	protected $longitude = 0.0;

	/**
	 * @var float
	 */
	protected $latitude = 0.0;

	/**
	 * @var string
	 */
	protected $city = '';

	/**
	 * @var string
	 */
	protected $creator = '';

	/**
	 * @var string
	 */
	protected $lastUpdater = '';

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var boolean
	 * @transient
	 */
	protected $isActive;

	/**
	 * @var boolean
	 * @transient
	 */
	protected $isPostBActive;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $photo = NULL;

	/**
	 * @var \Visol\EasyvoteLocation\Domain\Model\LocationType
	 */
	protected $locationType = NULL;

	/**
	 * @var string
	 */
	protected $street = '';

	/**
	 * @var string
	 */
	protected $zip = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay1 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay2 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay3 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay4 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay5 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay6 = '';

	/**
	 * @var string
	 */
	protected $emptyingTimeDay7 = '';

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
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the longitude
	 *
	 * @return float $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param float $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the latitude
	 *
	 * @return float $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param float $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the city
	 *
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the creator
	 *
	 * @return string $creator
	 */
	public function getCreator() {
		return $this->creator;
	}

	/**
	 * Sets the creator
	 *
	 * @param string $creator
	 * @return void
	 */
	public function setCreator($creator) {
		$this->creator = $creator;
	}

	/**
	 * Returns the lastUpdater
	 *
	 * @return string $lastUpdater
	 */
	public function getLastUpdater() {
		return $this->lastUpdater;
	}

	/**
	 * Sets the lastUpdater
	 *
	 * @param string $lastUpdater
	 * @return void
	 */
	public function setLastUpdater($lastUpdater) {
		$this->lastUpdater = $lastUpdater;
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
	 * @return string $isActive
	 */
	public function getIsActive() {
		if (is_null($this->isActive)) {
			$this->isActive = $this->getLocationService()->isActive();
		}
		return $this->isActive;
	}

	/**
	 * @return string $isActive
	 */
	public function getIsPostBActive() {
		if (is_null($this->isPostBActive)) {
			$this->isPostBActive = $this->getLocationService()->isPostBActive();
		}
		return $this->isPostBActive;
	}

	/**
	 * Returns the photo
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $photo
	 */
	public function getPhoto() {
		return $this->photo;
	}

	/**
	 * Sets the photo
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $photo
	 * @return void
	 */
	public function setPhoto(\TYPO3\CMS\Extbase\Domain\Model\FileReference $photo) {
		$this->photo = $photo;
	}

	/**
	 * Returns the locationType
	 *
	 * @return \Visol\EasyvoteLocation\Domain\Model\LocationType $locationType
	 */
	public function getLocationType() {
		return $this->locationType;
	}

	/**
	 * Sets the locationType
	 *
	 * @param \Visol\EasyvoteLocation\Domain\Model\LocationType $locationType
	 * @return void
	 */
	public function setLocationType(\Visol\EasyvoteLocation\Domain\Model\LocationType $locationType) {
		$this->locationType = $locationType;
	}

	/**
	 * @return string
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return $this
	 */
	public function setStreet($street) {
		$this->street = $street;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * @param string $zip
	 * @return $this
	 */
	public function setZip($zip) {
		$this->zip = $zip;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay1() {
		return $this->emptyingTimeDay1;
	}

	/**
	 * @param string $emptyingTimeDay1
	 * @return $this
	 */
	public function setEmptyingTimeDay1($emptyingTimeDay1) {
		$this->emptyingTimeDay1 = $emptyingTimeDay1;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay2() {
		return $this->emptyingTimeDay2;
	}

	/**
	 * @param string $emptyingTimeDay2
	 * @return $this
	 */
	public function setEmptyingTimeDay2($emptyingTimeDay2) {
		$this->emptyingTimeDay2 = $emptyingTimeDay2;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay3() {
		return $this->emptyingTimeDay3;
	}

	/**
	 * @param string $emptyingTimeDay3
	 * @return $this
	 */
	public function setEmptyingTimeDay3($emptyingTimeDay3) {
		$this->emptyingTimeDay3 = $emptyingTimeDay3;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay4() {
		return $this->emptyingTimeDay4;
	}

	/**
	 * @param string $emptyingTimeDay4
	 * @return $this
	 */
	public function setEmptyingTimeDay4($emptyingTimeDay4) {
		$this->emptyingTimeDay4 = $emptyingTimeDay4;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay5() {
		return $this->emptyingTimeDay5;
	}

	/**
	 * @param string $emptyingTimeDay5
	 * @return $this
	 */
	public function setEmptyingTimeDay5($emptyingTimeDay5) {
		$this->emptyingTimeDay5 = $emptyingTimeDay5;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay6() {
		return $this->emptyingTimeDay6;
	}

	/**
	 * @param string $emptyingTimeDay6
	 * @return $this
	 */
	public function setEmptyingTimeDay6($emptyingTimeDay6) {
		$this->emptyingTimeDay6 = $emptyingTimeDay6;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmptyingTimeDay7() {
		return $this->emptyingTimeDay7;
	}

	/**
	 * @param string $emptyingTimeDay7
	 * @return $this
	 */
	public function setEmptyingTimeDay7($emptyingTimeDay7) {
		$this->emptyingTimeDay7 = $emptyingTimeDay7;
		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'uid' => $this->getUid(),
			'pid' => $this->getPid(),
			'name' => $this->getName(),
			'longitude' => $this->getLongitude(),
			'latitude' => $this->getLatitude(),
			'city' => $this->getCity(),
			'description' => $this->getDescription(),
			'location_type' => $this->getLocationType(),
			'photo' => '',
			'street' => $this->getStreet(),
			'zip' => $this->getZip(),
			'emptying_time_day_1' => $this->getEmptyingTimeDay1(),
			'emptying_time_day_2' => $this->getEmptyingTimeDay2(),
			'emptying_time_day_3' => $this->getEmptyingTimeDay3(),
			'emptying_time_day_4' => $this->getEmptyingTimeDay4(),
			'emptying_time_day_5' => $this->getEmptyingTimeDay5(),
			'emptying_time_day_6' => $this->getEmptyingTimeDay6(),
			'emptying_time_day_7' => $this->getEmptyingTimeDay7(),
		);
	}

	/**
	 * @return \Visol\EasyvoteLocation\Service\LocationService
	 */
	protected function getLocationService() {
		return GeneralUtility::makeInstance('Visol\EasyvoteLocation\Service\LocationService', $this);
	}

}