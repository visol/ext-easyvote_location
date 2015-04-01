var map;

/**
 * Initialization of the map.
 */
function initialize() {

	map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: EasyVote.Zoom,
		center: new google.maps.LatLng(EasyVote.Latitude, EasyVote.Longitude),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	addMarkers();
	addLegend();

	// Try to position the map with current location.
	if (navigator.geolocation) {
		var timeoutVal = 10 * 1000 * 1000;
		navigator.geolocation.getCurrentPosition(
			setPositionOnMap,
			positionMapError,
			{enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0}
		);
	}

	// Save with and height for full screen mode
	var googleMapWidth = $("#map-container").css('width');
	var googleMapHeight = $("#map-container").css('height');

	$('#btn-enter-full-screen').click(function() {
		$("#map-container").css({
			position: 'fixed',
			top: 0,
			left: 0,
			width: '100%',
			height: '100%',
			backgroundColor: 'white'
		});

		$("#map-canvas").css({
			height: '100%'
		});

		google.maps.event.trigger(map, 'resize');

		// Gui
		$('#sitefooter').hide();
		$('#btn-enter-full-screen').toggle();
		$('#btn-exit-full-screen').toggle();
		return false;
	});

	$('#btn-exit-full-screen').click(function() {

		$("#map-container").css({
			position: 'relative',
			top: 0,
			//left: 0,
			width: googleMapWidth,
			height: googleMapHeight,
			backgroundColor: 'transparent'
		});

		google.maps.event.trigger(map, 'resize');

		// Gui
		$('#sitefooter').show();
		$('#btn-enter-full-screen').toggle();
		$('#btn-exit-full-screen').toggle();
		return false;
	});
}

/**
 * Display a legend
 *
 * @return void
 */
function addLegend() {

	var legend = document.createElement('div');
	legend.setAttribute('id', 'legend');
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
	//var serializedLocations = null; // debug
	var serializedLocations = sessionStorage.getItem('EasyVote.Locations');

	// If we don't have the points in Session Storage, fetch them by Ajax.
	if (!$.cookie('isDataValid') || !serializedLocations) {
		$.ajax({
			url: '/routing/locations',
			async: true,
			cache: true,
			success: function(locations) {

				// Store data for the session
				sessionStorage.setItem('EasyVote.Locations', JSON.stringify(locations));

				createMarkers(locations);

				$.cookie('isDataValid', 'true', { expires: getCookieLifeTime() });
			},
			error: function(xmlHttpRequest, textStatus, errorThrown) {
				console.log(xmlHttpRequest.toString());
				console.log(textStatus.toString());
				console.log(errorThrown.toString());
			}
		});
	} else {

		// We have data coming from the Session Storage. Simply create points on the map.
		var locations = JSON.parse(serializedLocations);
		createMarkers(locations);
	}
}

/**
 * Cookie expires every 0, 30 minutes
 *
 * @return {Date}
 */
function getCookieLifeTime() {

	var date = new Date();
	var minutes, hours;

	if (date.getMinutes() <= 30) {
		minutes = 30;
		hours = date.getHours();
	} else {
		minutes = 0;
		hours = date.getHours() + 1;
	}

	return new Date(
		date.getFullYear(),
		date.getMonth(),
		date.getDate(),
		hours,
		minutes,
		date.getSeconds()
	);

}

/**
 * Add bunch of markers.
 *
 * @param {array} locations
 * @return void
 */
function createMarkers(locations) {

	var markers1 = [];
	var markers2 = [];

	for (var i = 0; i < locations.length; i++) {
		var location = locations[i];

		var marker = createMarker(location);
		if (location.type === 1) {
			markers1.push(marker);
		} else if (location.type === 2 || location.type === 3) {
			markers2.push(marker);
		}
	}

	var options = {
		//gridSize: 100,
		maxZoom: 13,
		styles: [
			{
				height: 30,
				width: 30,
				textColor: '#ffffff',
				textSize: 11,
				url: "typo3conf/ext/easyvote_location/Resources/Public/Icons/ClustererBackground01.png"
			}
		]
	};

	new MarkerClusterer(map, markers1, options);
	options.styles = [
		{
			height: 30,
			width: 30,
			textColor: '#ffffff',
			textSize: 11,
			url: "typo3conf/ext/easyvote_location/Resources/Public/Icons/ClustererBackground02.png"
		}
	];

	new MarkerClusterer(map, markers2, options);

}

/**
 * @param location
 * @return string
 */
function computeIcon(location) {
	// Remove the trailing ".png" extension
	var iconBasePath = EasyVote.LocationTypes[location.type].icon.replace('.png', '');
	if (!location.active) {
		iconBasePath += 'Gray';
	}
	return iconBasePath + '.png';
}


/**
 * @param location
 * @return google.maps.Marker
 */
function createMarker(location) {
	var marker = new google.maps.Marker({
		id: location.id,
		position: new google.maps.LatLng(location.latitude, location.longitude),
		icon: computeIcon(location)
		//map: map
	});

	var infoWindow = new google.maps.InfoWindow({
		content: '<img src="/typo3conf/ext/easyvote_location/Resources/Public/Icons/loading.gif" alt="" />'
	});

	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map, marker);

		// Center the map around the bubble.
		var position = marker.getPosition();
		position.k = position.k + 0.001;
		map.setCenter(position);
		var isMissingContent = infoWindow.getContent().match('loading.gif');
		if (isMissingContent) {
			$.ajax({
				url: '/routing/locations/' + marker.id,
				success: function(location) {
					infoWindow.setContent(location.description);
				}
			});
		}
	});

	return marker;
}

/**
 *
 * @param error
 */
function positionMapError(error) {
	var errors = {
		1: 'Permission denied',
		2: 'Position unavailable',
		3: 'Request timeout'
	};
}

/**
 *
 * @param position
 */
function setPositionOnMap(position) {
	map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
	map.setZoom(14);
}
google.maps.event.addDomListener(window, 'load', initialize);

