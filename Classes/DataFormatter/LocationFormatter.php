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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
	protected function formatDescription(Location $location) {
		$description = '';

		if ((int)$location->getLocationType()->getUid() === LocationType::TYPE_POST_BOX) {
			$view = $this->getFluidView('PostBox');
			$view->assign('location', $location);
			$view->assign('numberOfParticipants', $this->calculateEventsParticipants($location));
			$description = $view->render();
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
		} elseif ((int)$location->getLocationType()->getUid() === LocationType::TYPE_POLLING_STATION) {
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
		} elseif ((int)$location->getLocationType()->getUid() === LocationType::TYPE_VOTENOW2015) {
			$view = $this->getFluidView('VoteNow2015');
			$view->assign('location', $location);
			$view->assign('numberOfParticipants', $this->calculateEventsParticipants($location));
			$description = $view->render();
		}
		return $description;
	}

	/**
	 * Calculates the number of people that will vote on a certain location
	 *
	 * @param $location \Visol\EasyvoteLocation\Domain\Model\Location
	 * @return int|null
	 */
	protected function calculateEventsParticipants($location) {
		if ($location->getEvents()->count()) {
			$counter = 0;
			foreach ($location->getEvents() as $event) {
				/** @var $event \Visol\Easyvote\Domain\Model\Event */
				// The organizer of the event is one participant
				$counter++;
				if ($event->getCommunityUser() instanceof \Visol\Easyvote\Domain\Model\CommunityUser) {
					$counter = $counter + $event->getCommunityUser()->getFollowers()->count();
				}
			}
			return $counter;
		} else {
			return NULL;
		}
	}

	/**
	 * @param string $templateName
	 * @return \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected function getFluidView($templateName) {

		$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

		/** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
		$view = $objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);
		$templatePath = sprintf('%sResources/Private/Templates/Standalone/%s.html',
			ExtensionManagementUtility::extPath('easyvote_location'),
			$templateName
		);
		$view->setTemplatePathAndFilename($templatePath);
		return $view;
	}
}