<?php
namespace Visol\EasyvoteLocation\DataFormatter;

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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Visol\EasyvoteLocation\Domain\Model\Location;
use Visol\EasyvoteLocation\Domain\Model\LocationType;

/**
 * Format a Location.
 */
class LocationFormatter {

	/**
	 * Format a Location.
	 *
	 * @param Location $location
	 * @return array
	 */
	public function format(Location $location) {

		$formattedData = array(
			'id' => $location->getUid(),
			'latitude' => $location->getLatitude(),
			'longitude' => $location->getLongitude(),
			'type' => $location->getLocationType()->getUid(),
			'description' => $this->formatDescription($location),
		);

		return $formattedData;
	}

	/**
	 * @param Location $location
	 * @return string
	 */
	public function formatDescription(Location $location) {
		$description = '';

		if ((int)$location->getLocationType()->getUid() === LocationType::TYPE_POST_BOX) {

			// @todo dynamic computing of description according to the next voting day

			/*
			 * Example:
			 * ---------
			 *
			 *  A-/B-Post möglich/ A-Post möglich/ Stimmabgabe geschlossen
			 *
			 *	Briefeinwurf
			 *	Ruhestrasse 2
			 *	8045 Zürich
			 *
			 *	Letzte Leerung
			 *	B-Post: Mittwoch, 25.02.15, 18.00 Uhr
			 *	A-Post: Donnerstag, 26.02.15, 18.00 Uhr
			 *  Find my way
			 */
			$text = <<<EOF
<strong>%s</strong><br/r>
%s<br/>
%s %s<br/>
<br/>
%s<br/>
%s: %s, 25.02.15, %s %s<br/>
%s: %s, 26.02.15, %s %s<br/>
<a href="https://www.google.com/maps/dir/Current+Location/%s,%s" target="_blank">%s</a>
EOF;

			$description = sprintf(
				$text,
				LocalizationUtility::translate('post_box', 'easyvote_location'),
				$location->getStreet(),
				$location->getZip(),
				$location->getCity(),
				LocalizationUtility::translate('last_emptying', 'easyvote_location'),
				LocalizationUtility::translate('post_b', 'easyvote_location'),
				LocalizationUtility::translate('wednesday', 'easyvote_location'),
				substr($location->getEmptyingTimeDay3(), 0, 5), // time
				LocalizationUtility::translate('hour', 'easyvote_location'),
				LocalizationUtility::translate('post_a', 'easyvote_location'),
				LocalizationUtility::translate('thursday', 'easyvote_location'),
				substr($location->getEmptyingTimeDay4(), 0, 5), // time
				LocalizationUtility::translate('hour', 'easyvote_location'),
				$location->getLatitude(),
				$location->getLongitude(),
				LocalizationUtility::translate('find_my_way', 'easyvote_location')
			);
		} elseif ((int)$location->getLocationType()->getUid() === LocationType::TYPE_MUNICIPAL_ADMINISTRATION) {
			/*
			 * Example:
			 * --------
			 *
			 * Stimmabgabe möglich / Stimmabgabe geschlossen
             *
			 * Gemeindeverwaltung
			 * Ruhestrasse 8
			 * 8045 Zürich
			 * Weitere Infos (Website)
			 *
			 * Letzte Leerung
			 * Freitag, 27.02.15, 17:30 Uhr
			 *
			 * Aktualisiert am 27.02.15 durch
			 * {Foto} Max M. aus Moosseedorf
			 *
			 * Ort bearbeiten
			 * Ort melden
             *  			 */
			$description = '';
		} elseif ((int)$location->getLocationType()->getUid() === LocationType::TYPE_MUNICIPAL_ADMINISTRATION) {
			/*
			 * Example:
			 * --------
			 * Geöffnet / Geschlossen
             *
			 * Schulhaus Laut
			 * Ruhestrasse 8
			 * 8045 Zürich
			 * Weitere Infos (Website)
			 *
			 * Öffnungszeiten
			 * Freitag, 27.02.15, 17:30-20:00 Uhr
			 * Sonntag, 28.02.15, 09:45-11:30 Uhr
			 *
			 * Aktualisiert am 27.02.15 durch
			 * {Foto} Max M. aus Moosseedorf
			 *
			 * Ort bearbeiten
			 * Ort melden
			 */
			$description = '';
		}
		return $description;
	}

}