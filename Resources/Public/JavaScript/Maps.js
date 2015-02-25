var map;
var markers = [];
function initialize() {

	map = new google.maps.Map(document.getElementById('map-canvas'), {
		//zoom: EasyVote.Zoom,
		zoom: 12,
		center: new google.maps.LatLng(EasyVote.Latitude, EasyVote.Longitude),
		//center: new google.maps.LatLng(37.4419, -122.1419),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	$.ajax({
		//url: "/data.json",
		url: EasyVote.Location,
		//type: "POST",
		//data: "{'id': '" + propertyid + "'}",
		async: true,
		cache: true,
		//contentType: "application/json;",
		//dataType: "json",
		success: function (data, textStatus, jqXHR) { //
			data = JSON && JSON.parse(data) || $.parseJSON(data);
			//mydata = data;
			//createPropertyMarkers();


			for (var i = 0; i < data.length; i++) {
				var location = data[i];


				var sizeX = 16;
				var sizeY = 16;
				var icon = {
					url: 'typo3conf/ext/easyvote_location/Resources/Public/Icons/PostBox.png',
					size: new google.maps.Size(sizeX, sizeY),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(sizeX/2, sizeY/2)
				};


				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(location.latitude,  location.longitude),
					map: map,
					draggable: false,
					icon: icon
				});

				//var marker = new google.maps.Marker({
				//	position: new google.maps.LatLng(location.latitude,  location.longitude),
				//	icon: icon
				//});
				//markers.push(marker);
			}

			//var markerCluster = new MarkerClusterer(map, markers);
		},
		error: function (xmlHttpRequest, textStatus, errorThrown) {
			console.log(xmlHttpRequest.responseText);
			console.log(textStatus);
			console.log(errorThrown);
			alert("Screen shot this error: " + xmlHttpRequest.toString() + " " + textStatus.toString() + " " + errorThrown.toString());
		}
	});

	icons = EasyVote.LocationTypes;

	function addMarker(location) {
		var marker = new google.maps.Marker({
			position: location.position,
			icon: icons[location.type].icon,
			map: map
		});

		var infowindow = new google.maps.InfoWindow({
			content: location.text
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}

	//var markers = [
	//	{
	//		position: new google.maps.LatLng(46.8131873, 8.2242101),
	//		type: '3',
	//		text: 'Uluru (Ayers Rock)'
	//	}
	//];

	//var markers = [];
	//for (var i = 0; i < 100; i++) {
	//	var dataPhoto = data.photos[i];
	//	var latLng = new google.maps.LatLng(dataPhoto.latitude,
	//		dataPhoto.longitude);
	//	var marker = new google.maps.Marker({
	//		position: latLng
	//	});
	//	markers.push(marker);
	//}
	//var markerCluster = new MarkerClusterer(map, markers);
	//for (var i = 0, marker; marker = markers[i]; i++) {
	//	addMarker(marker);
	//}

	var legend = document.getElementById('legend');
	for (var key in icons) {
		var type = icons[key];
		var name = type.name;
		var icon = type.icon;
		var div = document.createElement('div');
		//div.innerHTML = '<img src="' + icon + '"> ' + name;
		legend.appendChild(div);
	}

	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
}

google.maps.event.addDomListener(window, 'load', initialize);

