<?php
namespace Visol\EasyvoteLocation\Tests\JsonEncoder;

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

/**
 * Location Type encoder
 */
class LocationEncoderTest extends UnitTestCase {

	/**
	 * @var array
	 */
	protected $fakeLocation = array(
		'uid' => 1,
		'pid' => 0,
		'type' => 0,
		'name' => '',
		'longitude' => 7.06328339,
		'latitude' => 46.62212057,
		'city' => 'Bulle',
		'description' => 'Briefeinwurf Bulle, Route de Morlon',
		'is_available_for_current_voting_day' => 1,
		'location_type' => 1,
		'photo' => 0,
		'street' => 'Route de Morlon 23',
		'zip' => 1630,
		'canton' => '',
		'import_id' => '003BE_00325440',
		'emptying_time_day_1' => '19:00:00',
		'emptying_time_day_2' => '19:00:00',
		'emptying_time_day_3' => '19:00:00',
		'emptying_time_day_4' => '19:00:00',
		'emptying_time_day_5' => '19:00:00',
		'emptying_time_day_6' => '10:00:00',
		'emptying_time_day_7' => '14:30:00',
	);

	/**
	 * @var \Visol\EasyvoteLocation\JsonEncoder\LocationEncoder
	 */
	protected $fixture;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new \Visol\EasyvoteLocation\JsonEncoder\LocationEncoder();
	}

	/**
	 * @test
	 * @dataProvider timeProvider
	 * @param int $currentTime
	 * @param bool $expectedResult
	 */
	public function TestIsActiveForPostBox($currentTime, $expectedResult) {

		// Correspond to a Sunday
		date_default_timezone_set('Europe/Zurich');
		$fakeVotingLimit = strtotime('5 April 2015 00 hours 00 minutes') + 86400;

		/** @var \Visol\EasyvoteLocation\JsonEncoder\LocationEncoder|\PHPUnit_Framework_MockObject_MockObject $mockedObject */
		$mockedObject = $this->getMock(
			\Visol\EasyvoteLocation\JsonEncoder\LocationEncoder::class,
			array('getCurrentTime'),
			array()
		);

		$mockedObject->expects($this->any())
			->method('getCurrentTime')->will($this->returnValue($currentTime));

		// Trick for making the protected method accessible
		$method = new \ReflectionMethod(\Visol\EasyvoteLocation\JsonEncoder\LocationEncoder::class, 'isActiveForPostBox');
		$method->setAccessible(TRUE);
		$result = $method->invokeArgs($mockedObject, array($this->fakeLocation, $fakeVotingLimit));

		$this->assertEquals($result, $expectedResult);
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

}