class GeoLocation {

	/**
	 *
	 * @param Maps
	 */
	static askForGeoPosition(Maps) {

		GeoLocation.Maps = Maps;

		// Try to position the map with current location.
		if (navigator.geolocation) {
			var timeoutVal = 10 * 1000 * 1000;
			navigator.geolocation.getCurrentPosition(
				GeoLocation.setPositionOnMap,
				GeoLocation.positionMapError, {
					enableHighAccuracy: true,
					timeout: timeoutVal,
					maximumAge: 0
				});
		}
	}

	/**
	 *
	 * @param error
	 */
	static positionMapError(error) {
		var errors = {
			1: "Permission denied",
			2: "Position unavailable",
			3: "Request timeout"
		};
	}

	/**
	 *
	 * @param position
	 */
	static setPositionOnMap(position) {
		GeoLocation.Maps.getMap().setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
		GeoLocation.Maps.getMap().setZoom(14);
	}

}

export default GeoLocation