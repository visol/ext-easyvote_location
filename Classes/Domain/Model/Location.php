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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Location
 */
class Location extends AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address = '';

	/**
	 * longitude
	 *
	 * @var float
	 */
	protected $longitude = 0.0;

	/**
	 * latitude
	 *
	 * @var float
	 */
	protected $latitude = 0.0;

	/**
	 * city
	 *
	 * @var string
	 */
	protected $city = '';

	/**
	 * creator
	 *
	 * @var string
	 */
	protected $creator = '';

	/**
	 * lastUpdater
	 *
	 * @var string
	 */
	protected $lastUpdater = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * isAvailableForCurrentVotingDay
	 *
	 * @var string
	 */
	protected $isAvailableForCurrentVotingDay = '';

	/**
	 * photo
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $photo = NULL;

	/**
	 * locationType
	 *
	 * @var \Visol\EasyvoteLocation\Domain\Model\LocationType
	 */
	protected $locationType = NULL;

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
	 * Returns the isAvailableForCurrentVotingDay
	 *
	 * @return string $isAvailableForCurrentVotingDay
	 */
	public function getIsAvailableForCurrentVotingDay() {
		return $this->isAvailableForCurrentVotingDay;
	}

	/**
	 * Sets the isAvailableForCurrentVotingDay
	 *
	 * @param string $isAvailableForCurrentVotingDay
	 * @return void
	 */
	public function setIsAvailableForCurrentVotingDay($isAvailableForCurrentVotingDay) {
		$this->isAvailableForCurrentVotingDay = $isAvailableForCurrentVotingDay;
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

}