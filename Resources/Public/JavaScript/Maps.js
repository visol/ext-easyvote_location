var map;
var markers = [];

/**
 * Initialization of the map.
 */
function initialize() {

	map = new google.maps.Map(document.getElementById('map-canvas'), {
		//zoom: EasyVote.Zoom,
		zoom: 12,
		center: new google.maps.LatLng(EasyVote.Latitude, EasyVote.Longitude),
		//center: new google.maps.LatLng(37.4419, -122.1419),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	addMarkers();
	addLegend();

	/**
	 * Register handler while map is updating in a way or another.
	 */
	google.maps.event.addListener(map, 'idle', function () {
		// @todo store current center and zoom while developing
	});
}


/**
 * Display
 *
 * @return void
 */
function addLegend() {

	var legend = document.getElementById('legend');
	for (var key in EasyVote.LocationTypes) {
		var type = EasyVote.LocationTypes[key];
		var name = type.name;
		var icon = type.icon;
		var div = document.createElement('div');
		div.innerHTML = '<img src="' + icon + '"> ' + name;
		legend.appendChild(div);
	}

	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
}

/**
 * Add bunch of markers.
 *
 * @return void
 */
function addMarkers() {
	//var serializedLocations = localStorage.getItem('EasyVote.Locations');
	// localStorage is not big enough, rather consider
	// http://stackoverflow.com/questions/2989284/what-is-the-max-size-of-localstorage-values
	// http://rhaboo.org/
	var serializedLocations = null;
	if (!serializedLocations) {
		$.ajax({
			url: EasyVote.Location,
			//type: "POST",
			//data: "{'id': '" + propertyid + "'}",
			async: true,
			cache: true,
			//contentType: "application/json;",
			//dataType: "json",
			success: function (locations, textStatus, jqXHR) {

				// Store
				//localStorage.setItem('EasyVote.Locations', locations); // JSON.stringify(locations)

				locations = JSON && JSON.parse(locations) || $.parseJSON(locations);
				createMarkers(locations);
			},
			error: function (xmlHttpRequest, textStatus, errorThrown) {
				console.log(xmlHttpRequest.toString());
				console.log(textStatus.toString());
				console.log(errorThrown.toString());
			}
		});
	} else {
		var locations = JSON.parse(serializedLocations);
		createMarkers(locations);
	}
}

/**
 * Add bunch of markers.
 *
 * @param {array} locations
 * @return void
 */
function createMarkers(locations) {
	for (var i = 0; i < locations.length; i++) {
		var location = locations[i];

		var marker = createMarker(location)
		markers.push(marker);
	}

	var markerCluster = new MarkerClusterer(map, markers);
}

/**
 *
 * @param location
 * @return google.maps.Marker
 */
function createMarker(location) {
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(location.latitude,  location.longitude),
		icon: EasyVote.LocationTypes[location.type].icon
		//map: map
	});

	var infowindow = new google.maps.InfoWindow({
		content: location.description
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

	return marker;
}

google.maps.event.addDomListener(window, 'load', initialize);

