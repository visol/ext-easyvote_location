var map;
function initialize() {
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: EasyVote.Zoom,
		center: new google.maps.LatLng(EasyVote.Latitude, EasyVote.Longitude),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	icons = EasyVote.LocationTypes;

	function addMarker(feature) {
		var marker = new google.maps.Marker({
			position: feature.position,
			icon: icons[feature.type].icon,
			map: map
		});
	}

	var features = [
		{
			position: new google.maps.LatLng(46.8131873, 8.2242101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8131372, 8.22742202),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8131873, 8.2542101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8431873, 8.22142101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8151873, 8.22424101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8131673, 8.22412101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8181873, 8.22342101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.9131873, 8.2292101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8131833, 8.2212101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8131673, 8.2222101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8132873, 8.2272101),
			type: '3'
		}, {
			position: new google.maps.LatLng(46.8171873, 8.2222101),
			type: '1'
		}, {
			position: new google.maps.LatLng(46.8191873, 8.2282101),
			type: '1'
		}, {
			position: new google.maps.LatLng(46.8132873, 8.2272101),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.919543720969806, 151.23112279762267),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.91608037421864, 151.23288232673644),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.91851096391805, 151.2344058214569),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.91818154739766, 151.2346203981781),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
			type: '2'
		}
	];

	for (var i = 0, feature; feature = features[i]; i++) {
		addMarker(feature);
	}

	var legend = document.getElementById('legend');
	for (var key in icons) {
		var type = icons[key];
		var name = type.name;
		var icon = type.icon;
		var div = document.createElement('div');
		div.innerHTML = '<img src="' + icon + '"> ' + name;
		legend.appendChild(div);
	}

	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
}

google.maps.event.addDomListener(window, 'load', initialize);