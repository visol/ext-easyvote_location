import Cookie from './Cookie.js'
import GeoLocation from './GeoLocation.js'

class Maps {

	/**
	 * Class Factory
	 *
	 * @return Maps
	 */
	static getInstance() {
		if (!this.instance) {
			this.instance = new Maps();
		}
		return this.instance;
	}

	/**
	 * Initialization of the map.
	 */
	constructor() {

		this.infoWindowReference = null;
		this.map = new google.maps.Map(document.getElementById("map-canvas"), {
			zoom: EasyvoteLocation.Zoom,
			center: new google.maps.LatLng(EasyvoteLocation.Latitude, EasyvoteLocation.Longitude),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		this.addMarkers();
		this.addLegend();
		this.addFullScreenCapability();

		GeoLocation.askForGeoPosition(this);
	}

	/**
	 * Display a legend
	 *
	 * @return void
	 */
	addLegend() {

		var legend = document.createElement("div");
		legend.setAttribute("id", "legend");
		for (var key in EasyvoteLocation.LocationTypes) {
			var type = EasyvoteLocation.LocationTypes[key];
			var name = type.name;
			var icon = type.icon;
			var div = document.createElement("div");
			div.innerHTML = "<img src=\"" + icon + "\"> " + name;
			legend.appendChild(div);
		}

		this.map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
	}

	/**
	 * Add bunch of markers.
	 *
	 * @return void
	 */
	addMarkers() {
		//var serializedLocations = null; // debug
		var serializedLocations = sessionStorage.getItem("EasyvoteLocation.Locations");

		// If we don't have the points in Session Storage, fetch them by Ajax.
		if (!$.cookie("isDataValid") || !serializedLocations) {
			$.ajax({
				url: "/routing/locations",
				async: true,
				cache: true,
				success: function success(locations) {

					// Store data for the session
					sessionStorage.setItem("EasyvoteLocation.Locations", JSON.stringify(locations));

					Maps.getInstance().createMarkers(locations);

					$.cookie("isDataValid", "true", {expires: Cookie.getCookieLifeTime()});
				},
				error: function error(xmlHttpRequest, textStatus, errorThrown) {
					console.log(xmlHttpRequest.toString());
					console.log(textStatus.toString());
					console.log(errorThrown.toString());
				}
			});
		} else {

			// We have data coming from the Session Storage. Simply create points on the map.
			var locations = JSON.parse(serializedLocations);
			this.createMarkers(locations);
		}
	}

	/**
	 * Add bunch of markers.
	 *
	 * @param {array} locations
	 * @return void
	 */
	createMarkers(locations) {

		var markers1 = [];
		var markers2 = [];

		for (var i = 0; i < locations.length; i++) {
			var location = locations[i];

			var marker = this.createMarker(location);
			if (location.type === 1) {
				markers1.push(marker);
			} else if (location.type === 2 || location.type === 3 || location.type === 10) {
				markers2.push(marker);
			}
		}

		var options = {
			//gridSize: 100,
			maxZoom: 13,
			styles: [{
				height: 30,
				width: 30,
				textColor: "#ffffff",
				textSize: 11,
				url: "typo3conf/ext/easyvote_location/Resources/Public/Icons/ClustererBackground01.png"
			}]
		};

		new MarkerClusterer(this.map, markers1, options);
		options.styles = [{
			height: 30,
			width: 30,
			textColor: "#ffffff",
			textSize: 11,
			url: "typo3conf/ext/easyvote_location/Resources/Public/Icons/ClustererBackground02.png"
		}];

		new MarkerClusterer(this.map, markers2, options);
	}

	/**
	 * @param {Object} location
	 * @return string
	 */
	computeIcon(location) {
		// Remove the trailing ".png" extension
		var iconBasePath = EasyvoteLocation.LocationTypes[location.type].icon.replace(".png", "");
		if (!location.active) {
			iconBasePath += "Gray";
		}
		return iconBasePath + ".png";
	}

	/**
	 * @param location
	 * @return google.maps.Marker
	 */
	createMarker(location) {
		var marker = new google.maps.Marker({
			id: location.id,
			position: new google.maps.LatLng(location.latitude, location.longitude),
			icon: this.computeIcon(location)
			//map: map
		});

		var boxWidth = 300;
		var loading = "<img src=\"/typo3conf/ext/easyvote_location/Resources/Public/Icons/loading.gif\" alt=\"\" />";
		var infoBox = new InfoBox({
			content: `<div class="maps-infoBox" style="text-align: center">${loading}</div>`,
			pixelOffset: new google.maps.Size(boxWidth / 2 * -1, -40),
			alignBottom: true,
			disableAutoPan: true,
			boxStyle: {
				width: boxWidth + 'px'
			},
			closeBoxMargin: '5px',
			closeBoxURL: '/typo3conf/ext/easyvote_location/Resources/Public/Icons/Close.png',
			infoBoxClearance: new google.maps.Size(50, 250),
			enableEventPropagation: false
		});

		google.maps.event.addListener(marker, 'click', function() {

			// close previous opened info window
			if (Maps.getInstance().getInfoWindowReference()) {
				Maps.getInstance().getInfoWindowReference().close();
			}
			Maps.getInstance().setInfoWindowReference(infoBox);

			infoBox.open(this.map, this);

			// Additional listener in case the infoBox
			// is still opening if / when the answer of the server is slow.
			google.maps.event.addListener(infoBox, 'domready', function(){
				let markerPixel = infoBox.getProjection().fromLatLngToContainerPixel(infoBox.getPosition());
				let centerPixel = infoBox.getProjection().fromLatLngToContainerPixel(this.map.getCenter());

				let correction = 150; // correction so that the bubble is displayed in the map
				let moveX = (centerPixel.x - markerPixel.x) * -1;
				let moveY = (centerPixel.y - markerPixel.y) * -1 - correction;
				this.map.panBy(moveX, moveY);

				var isMissingContent = infoBox.getContent().match('loading.gif');
				if (isMissingContent) {
					$.ajax({
						url: '/routing/locations/' + marker.id + '?L=' + EasyvoteLocation.Language,
						success: function success(location) {
							var content = `<div class="maps-infoBox">${location.description}</div>`;
							infoBox.setContent(content);
						}
					});
				}
			});
		});

		return marker;
	}

	/**
	 * @return void
	 */
	addFullScreenCapability() {
		// Save with and height for full screen mode
		var googleMapWidth = $("#map-container").css("width");
		var googleMapHeight = $("#map-container").css("height");
		var canvasHeight = $("#map-canvas").css("height");

		$("#btn-enter-full-screen").click(function() {
			$("#map-container").css({
				position: "fixed",
				top: 0,
				left: 0,
				width: "100%",
				height: "100%",
				backgroundColor: "white"
			});

			// give enough room for full screen exit
			$("#map-canvas").css({
				height: $(window).height() - 25 + 'px'
			});

			google.maps.event.trigger(Maps.getInstance().getMap(), 'resize');

			// Gui
			$('#sitefooter').hide();
			$('#btn-enter-full-screen').toggle();
			$('#btn-exit-full-screen').toggle();
			return false;
		});

		$('#btn-exit-full-screen').click(function() {

			$('#map-container').css({
				position: 'relative',
				top: 0,
				//left: 0,
				width: googleMapWidth,
				height: googleMapHeight,
				backgroundColor: 'transparent'
			});

			$("#map-canvas").css({
				height: canvasHeight
			});

			google.maps.event.trigger(Maps.getInstance().getMap(), 'resize');

			// Gui
			$("#sitefooter").show();
			$("#btn-enter-full-screen").toggle();
			$("#btn-exit-full-screen").toggle();
			return false;
		});
	}

	/**
	 * @returns google.maps.Map
	 */
	getMap() {
		return this.map;
	}

	/**
	 * @returns InfoBox
	 */
	getInfoWindowReference() {
		return this.infoWindowReference;
	}

	/**
	 * @param {InfoBox} infoWindowReference
	 */
	setInfoWindowReference(infoWindowReference) {
		this.infoWindowReference = infoWindowReference;
	}
}

export default Maps