<?php
namespace Visol\EasyvoteLocation\UserFunc;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Xavier Perseguers <xavier@causal.ch>, Causal SÃ rl
 *  (c) 2015 Lorenz Ulrich <lorenz.ulrich@visol.ch>, visol digitale Dienstleistungen GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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


class Map {

	/**
	 * Renders the Google map.
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formEngineObject
	 * @return string
	 */
	public function render(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $formEngineObject) {
		$out = array();
		$latitude = (float)$PA['row'][$PA['parameters']['latitude']];
		$longitude = (float)$PA['row'][$PA['parameters']['longitude']];

		$baseElementId = isset($PA['itemFormElID']) ? $PA['itemFormElID'] : $PA['table'] . '_map';
		$addressId = $baseElementId . '_address';
		$mapId = $baseElementId . '_map';

		$dataPrefix = 'data[' . $PA['table'] . '][' . $PA['row']['uid'] . ']';
		$latitudeField = $dataPrefix . '[' . $PA['parameters']['latitude'] . ']';
		$longitudeField = $dataPrefix . '[' . $PA['parameters']['longitude'] . ']';

		$updateJs = "TBE_EDITOR.fieldChanged('%s','%s','%s','%s');";
		$updateLatitudeJs = sprintf($updateJs, $PA['table'], $PA['row']['uid'], $PA['parameters']['latitude'], $latitudeField);
		$updateLongitudeJs = sprintf($updateJs, $PA['table'], $PA['row']['uid'], $PA['parameters']['longitude'], $longitudeField);

		$out[] = '<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false&language=de"></script>';
		$out[] = '<script type="text/javascript">';
		$out[] = <<<EOT
if (typeof TxEasyvoteLocationLocation == 'undefined') TxEasyvoteLocationLocation = {};
TxEasyvoteLocationLocation
TxEasyvoteLocationLocation.init = function() {
	TxEasyvoteLocationLocation.origin = new google.maps.LatLng({$latitude}, {$longitude});
	var myOptions = {
		zoom: 13,
		center: TxEasyvoteLocationLocation.origin,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	TxEasyvoteLocationLocation.map = new google.maps.Map(document.getElementById("{$mapId}"), myOptions);
	TxEasyvoteLocationLocation.marker = new google.maps.Marker({
		map: TxEasyvoteLocationLocation.map,
		position: TxEasyvoteLocationLocation.origin,
		draggable: true
	});
	google.maps.event.addListener(TxEasyvoteLocationLocation.marker, 'dragend', function() {
		var lat = TxEasyvoteLocationLocation.marker.getPosition().lat().toFixed(8);
		var lng = TxEasyvoteLocationLocation.marker.getPosition().lng().toFixed(8);

		// Update visible fields
		document[TBE_EDITOR.formname]['{$latitudeField}_hr'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}_hr'].value = lng;

		// Update hidden (real) fields
		document[TBE_EDITOR.formname]['{$latitudeField}'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}'].value = lng;

		// Update address
		TxEasyvoteLocationLocation.reverseGeocode(TxEasyvoteLocationLocation.marker.getPosition().lat(), TxEasyvoteLocationLocation.marker.getPosition().lng());

		// Tell TYPO3 that fields were updated
		{$updateLatitudeJs}
		{$updateLongitudeJs}
	});
	TxEasyvoteLocationLocation.geocoder = new google.maps.Geocoder();
	TxEasyvoteLocationLocation.reverseGeocode({$latitude}, {$longitude});

	// Make sure to refresh Google Map if corresponding tab is not yet active
	TxEasyvoteLocationLocation.tabPrefix = Ext.fly('{$mapId}').findParentNode('[id$="-DIV"]').id;
	TxEasyvoteLocationLocation.tabPrefix = Ext.util.Format.substr(TxEasyvoteLocationLocation.tabPrefix, 0, TxEasyvoteLocationLocation.tabPrefix.length - 4);
	if (Ext.fly(TxEasyvoteLocationLocation.tabPrefix + '-DIV').getStyle('display') == 'none') {
		Ext.fly(TxEasyvoteLocationLocation.tabPrefix + '-MENU').on('click', TxEasyvoteLocationLocation.refreshMap);
	}
};

TxEasyvoteLocationLocation.refreshMap = function() {
	google.maps.event.trigger(TxEasyvoteLocationLocation.map, 'resize');
	// No need to do it again
	Ext.fly(TxEasyvoteLocationLocation.tabPrefix + '-MENU').un('click', TxEasyvoteLocationLocation.refreshMap);
}

TxEasyvoteLocationLocation.codeAddress = function() {
	var address = document.getElementById("{$addressId}").value;
	TxEasyvoteLocationLocation.geocoder.geocode({'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			TxEasyvoteLocationLocation.map.setCenter(results[0].geometry.location);
			TxEasyvoteLocationLocation.marker.setPosition(results[0].geometry.location);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

TxEasyvoteLocationLocation.reverseGeocode = function(latitude, longitude) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	TxEasyvoteLocationLocation.geocoder.geocode({'latLng': latlng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK && results[1]) {
			var address = document.getElementById("{$addressId}");
			address.value = results[1].formatted_address;
		}
	});
}

window.onload = TxEasyvoteLocationLocation.init;
EOT;
		$out[] = '</script>';
		$out[] = '<div id="' . $baseElementId . '">';
		$out[] = '
			<input id="' . $addressId . '" type="textbox" value="" style="width:300px">
			<input type="button" value="Show" onclick="TxEasyvoteLocationLocation.codeAddress()">
			<p style="margin:1em 0">Move the marker to update the GPS coordinates above</p>
		';
		$out[] = '<div id="' . $mapId . '" style="height:500px;width:100%"></div>';
		$out[] = '</div>'; // id=$baseElementId

		return implode('', $out);
	}

}

