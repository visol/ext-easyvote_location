<?php
namespace Visol\EasyvoteLocation\Tests\Service;

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

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Visol\EasyvoteLocation\Domain\Model\Location;
use Visol\EasyvoteLocation\Service\VotingDayService;

/**
 * Location Type encoder
 */
class LocationServiceTest extends UnitTestCase {

	/**
	 * @var array
	 */
	protected $fakeLocation = array(
		'uid' => 1,
		'pid' => 0,
		'name' => '',
		'longitude' => 7.06328339,
		'latitude' => 46.62212057,
		'city' => 'Bulle',
		'description' => 'Briefeinwurf Bulle, Route de Morlon',
		'location_type' => 1,
		'photo' => '',
		'street' => 'Route de Morlon 23',
		'zip' => 1630,
		'emptying_time_day_1' => '19:00:00',
		'emptying_time_day_2' => '19:00:00',
		'emptying_time_day_3' => '19:00:00',
		'emptying_time_day_4' => '19:00:00',
		'emptying_time_day_5' => '19:00:00',
		'emptying_time_day_6' => '10:00:00',
		'emptying_time_day_7' => '14:30:00',
	);

	/**
	 * @return void
	 */
	public function setUp() {

	}

	/**
	 * @test
	 * @dataProvider timeProvider
	 * @param int $currentTime
	 * @param bool $expectedResult
	 */
	public function TestIsActiveWithProvider($currentTime, $expectedResult) {

		$mockedObject = $this->getMockedLocationService($currentTime);

		$result = $mockedObject->isActive();
		$this->assertEquals($result, $expectedResult);
	}

	/**
	 * @test
	 * @dataProvider timePostBProvider
	 * @param int $currentTime
	 * @param bool $expectedResult
	 */
	public function TestIsPostBActiveWithProvider($currentTime, $expectedResult) {

		$mockedObject = $this->getMockedLocationService($currentTime);

		$result = $mockedObject->isPostBActive();
		$this->assertEquals($result, $expectedResult);
	}

	/**
	 * @test
	 */
	public function passingObjectToConstructorConvertAttributeLocationToArray() {

		$fakeLocationObject = $this->getFakeLocationObject();
		$fixture = new \Visol\EasyvoteLocation\Service\LocationService($fakeLocationObject);
		$reflection = new \ReflectionClass($fixture);

		$property = $reflection->getProperty('location');
		$property->setAccessible(true);
		$result = $property->getValue($fixture);

		$this->assertEquals($result, $this->fakeLocation);
	}

	/**
	 * Provider
	 */
	public function timeProvider() {
		date_default_timezone_set('Europe/Zurich');
		return array(
			array(strtotime('10 April 2015 12 hours 00 minutes'), FALSE), // Really after
			array(strtotime('4 April 2015 12 hours 00 minutes'), FALSE), // Saturday some time
			array(strtotime('2 April 2015 19 hours 00 minutes'), FALSE), // Deadline
			array(strtotime('2 April 2015 18 hours 59 minutes'), TRUE), // one minute before deadline
			array(strtotime('30 March 2015 18 hours 59 minutes'), TRUE), // Really before
		);
	}

	/**
	 * Provider
	 */
	public function timePostBProvider() {
		date_default_timezone_set('Europe/Zurich');
		return array(
			array(strtotime('10 April 2015 12 hours 00 minutes'), FALSE), // Really after
			array(strtotime('4 April 2015 12 hours 00 minutes'), FALSE), // Saturday some time
			array(strtotime('2 April 2015 19 hours 00 minutes'), FALSE), // Post-a Deadline
			array(strtotime('2 April 2015 18 hours 59 minutes'), FALSE), // Post-a one minute before deadline
			array(strtotime('1 April 2015 19 hours 00 minutes'), FALSE), // Deadline
			array(strtotime('1 April 2015 18 hours 59 minutes'), TRUE), // one minute before deadline
			array(strtotime('30 March 2015 18 hours 59 minutes'), TRUE), // Really before
		);
	}

	/**
	 * @param int $currentTime
	 * @return \PHPUnit_Framework_MockObject_MockObject|\Visol\EasyvoteLocation\Service\LocationService
	 */
	private function getMockedLocationService($currentTime){

		/** @var \Visol\EasyvoteLocation\Service\LocationService|\PHPUnit_Framework_MockObject_MockObject $mockedObject */
		$mockedObject = $this->getMock(
			\Visol\EasyvoteLocation\Service\LocationService::class,
			array('getCurrentTime', 'getVotingDayService'),
			array($this->fakeLocation)
		);

		$mockedObject->expects($this->any())
			->method('getCurrentTime')->will($this->returnValue($currentTime));

		// Configure return of getVotingDayService
		$mockedObject->expects($this->any())
			->method('getVotingDayService')->will($this->returnValue($this->getMockedVotingDayService()));

		return $mockedObject;
	}

	/**
	 * @return Location
	 */
	private function getFakeLocationObject() {
		$fakeLocation = new Location();

		$fakeLocation->_setProperty('uid', $this->fakeLocation['uid']);
		$fakeLocation->_setProperty('pid', $this->fakeLocation['pid']);
		$fakeLocation->_setProperty('name', $this->fakeLocation['name']);
		$fakeLocation->_setProperty('longitude', $this->fakeLocation['longitude']);
		$fakeLocation->_setProperty('latitude', $this->fakeLocation['latitude']);
		$fakeLocation->_setProperty('city', $this->fakeLocation['city']);
		$fakeLocation->_setProperty('description', $this->fakeLocation['description']);
		$fakeLocation->_setProperty('locationType', $this->fakeLocation['location_type']);
		$fakeLocation->_setProperty('photo', $this->fakeLocation['photo']);
		$fakeLocation->_setProperty('street', $this->fakeLocation['street']);
		$fakeLocation->_setProperty('zip', $this->fakeLocation['zip']);
		$fakeLocation->_setProperty('emptyingTimeDay1', $this->fakeLocation['emptying_time_day_1']);
		$fakeLocation->_setProperty('emptyingTimeDay2', $this->fakeLocation['emptying_time_day_2']);
		$fakeLocation->_setProperty('emptyingTimeDay3', $this->fakeLocation['emptying_time_day_3']);
		$fakeLocation->_setProperty('emptyingTimeDay4', $this->fakeLocation['emptying_time_day_4']);
		$fakeLocation->_setProperty('emptyingTimeDay5', $this->fakeLocation['emptying_time_day_5']);
		$fakeLocation->_setProperty('emptyingTimeDay6', $this->fakeLocation['emptying_time_day_6']);
		$fakeLocation->_setProperty('emptyingTimeDay7', $this->fakeLocation['emptying_time_day_7']);
		return $fakeLocation;
	}

	/**
	 * @return \Visol\EasyvoteLocation\Service\VotingDayService|\PHPUnit_Framework_MockObject_MockObject
	 */
	private function getMockedVotingDayService(){

		// Correspond to a Sunday
		date_default_timezone_set('Europe/Zurich');
		$fakeVotingLimit = strtotime('5 April 2015 00 hours 00 minutes') + 86400;

		$fakeVotingDayService = $this->getMock(
			VotingDayService::class,
			array('getTimeLimit'),
			array()
		);

		// Configure return of getTimeLimit
		$fakeVotingDayService->expects($this->any())
			->method('getTimeLimit')->will($this->returnValue($fakeVotingLimit));

		return $fakeVotingDayService;
	}

}