<?php

namespace Visol\EasyvoteLocation\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Fabien Udriot <fabien@udriot.net>, Visol
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Visol\EasyvoteLocation\Domain\Model\LocationType.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Fabien Udriot <fabien@udriot.net>
 */
class LocationTypeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Visol\EasyvoteLocation\Domain\Model\LocationType
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Visol\EasyvoteLocation\Domain\Model\LocationType();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIconReturnsInitialValueForFileReference() {
		$this->assertEquals(
			NULL,
			$this->subject->getIcon()
		);
	}

	/**
	 * @test
	 */
	public function setIconForFileReferenceSetsIcon() {
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setIcon($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'icon',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIsContentEditableReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->subject->getIsContentEditable()
		);
	}

	/**
	 * @test
	 */
	public function setIsContentEditableForBooleanSetsIsContentEditable() {
		$this->subject->setIsContentEditable(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'isContentEditable',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLocationsReturnsInitialValueForLocation() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getLocations()
		);
	}

	/**
	 * @test
	 */
	public function setLocationsForObjectStorageContainingLocationSetsLocations() {
		$location = new \Visol\EasyvoteLocation\Domain\Model\Location();
		$objectStorageHoldingExactlyOneLocations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneLocations->attach($location);
		$this->subject->setLocations($objectStorageHoldingExactlyOneLocations);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneLocations,
			'locations',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addLocationToObjectStorageHoldingLocations() {
		$location = new \Visol\EasyvoteLocation\Domain\Model\Location();
		$locationsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$locationsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($location));
		$this->inject($this->subject, 'locations', $locationsObjectStorageMock);

		$this->subject->addLocation($location);
	}

	/**
	 * @test
	 */
	public function removeLocationFromObjectStorageHoldingLocations() {
		$location = new \Visol\EasyvoteLocation\Domain\Model\Location();
		$locationsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$locationsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($location));
		$this->inject($this->subject, 'locations', $locationsObjectStorageMock);

		$this->subject->removeLocation($location);

	}
}
