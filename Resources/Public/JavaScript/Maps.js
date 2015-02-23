var map;
function initialize() {
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: 16,
		center: new google.maps.LatLng(-33.91722, 151.23064),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	icons = EV.LocationTypes;

	function addMarker(feature) {
		var marker = new google.maps.Marker({
			position: feature.position,
			icon: icons[feature.type].icon,
			map: map
		});
	}

	var features = [
		{
			position: new google.maps.LatLng(-33.91721, 151.22630),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91539, 151.22820),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91747, 151.22912),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91910, 151.22907),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91725, 151.23011),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91872, 151.23089),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91784, 151.23094),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91682, 151.23149),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91790, 151.23463),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91666, 151.23468),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.916988, 151.233640),
			type: '3'
		}, {
			position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
			type: '1'
		}, {
			position: new google.maps.LatLng(-33.91665018901448, 151.2282474695587),
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