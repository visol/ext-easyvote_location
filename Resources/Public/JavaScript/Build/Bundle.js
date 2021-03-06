(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

var _interopRequire = require("babel-runtime/helpers/interop-require")["default"];

// Initialize the map.

var Maps = _interopRequire(require("./Maps.js"));

google.maps.event.addDomListener(window, "load", function () {
	Maps.getInstance();
});

// Initialize the search form.

var SearchForm = _interopRequire(require("./SearchForm.js"));

var search = new SearchForm();

// Add some responsiveness feature such as the search form
// which should be displayed elsewhere in the mobile layout.

var Responsive = _interopRequire(require("./Responsive.js"));

var responsive = new Responsive();
responsive.bindAction();
},{"./Maps.js":4,"./Responsive.js":5,"./SearchForm.js":6,"babel-runtime/helpers/interop-require":9}],2:[function(require,module,exports){
"use strict";

var _classCallCheck = require("babel-runtime/helpers/class-call-check")["default"];

var _createClass = require("babel-runtime/helpers/create-class")["default"];

var Cookie = (function () {
	function Cookie() {
		_classCallCheck(this, Cookie);
	}

	_createClass(Cookie, null, {
		getCookieLifeTime: {

			/**
    * Cookie expires every 0, 30 minutes
    *
    * @return {Date}
    */

			value: function getCookieLifeTime() {

				var date = new Date();
				var minutes, hours;

				if (date.getMinutes() <= 30) {
					minutes = 30;
					hours = date.getHours();
				} else {
					minutes = 0;
					hours = date.getHours() + 1;
				}

				return new Date(date.getFullYear(), date.getMonth(), date.getDate(), hours, minutes, date.getSeconds());
			}
		}
	});

	return Cookie;
})();

module.exports = Cookie;
},{"babel-runtime/helpers/class-call-check":7,"babel-runtime/helpers/create-class":8}],3:[function(require,module,exports){
"use strict";

var _classCallCheck = require("babel-runtime/helpers/class-call-check")["default"];

var _createClass = require("babel-runtime/helpers/create-class")["default"];

var GeoLocation = (function () {
	function GeoLocation() {
		_classCallCheck(this, GeoLocation);
	}

	_createClass(GeoLocation, null, {
		askForGeoPosition: {

			/**
    *
    * @param Maps
    */

			value: function askForGeoPosition(Maps) {

				GeoLocation.Maps = Maps;

				// Try to position the map with current location.
				if (navigator.geolocation) {
					var timeoutVal = 10 * 1000 * 1000;
					navigator.geolocation.getCurrentPosition(GeoLocation.setPositionOnMap, GeoLocation.positionMapError, {
						enableHighAccuracy: true,
						timeout: timeoutVal,
						maximumAge: 0
					});
				}
			}
		},
		positionMapError: {

			/**
    *
    * @param error
    */

			value: function positionMapError(error) {
				var errors = {
					1: "Permission denied",
					2: "Position unavailable",
					3: "Request timeout"
				};
			}
		},
		setPositionOnMap: {

			/**
    *
    * @param position
    */

			value: function setPositionOnMap(position) {
				GeoLocation.Maps.getMap().setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
				GeoLocation.Maps.getMap().setZoom(14);
			}
		}
	});

	return GeoLocation;
})();

module.exports = GeoLocation;
},{"babel-runtime/helpers/class-call-check":7,"babel-runtime/helpers/create-class":8}],4:[function(require,module,exports){
"use strict";

var _classCallCheck = require("babel-runtime/helpers/class-call-check")["default"];

var _createClass = require("babel-runtime/helpers/create-class")["default"];

var _interopRequire = require("babel-runtime/helpers/interop-require")["default"];

var Cookie = _interopRequire(require("./Cookie.js"));

var GeoLocation = _interopRequire(require("./GeoLocation.js"));

var Maps = (function () {

	/**
  * Initialization of the map.
  */

	function Maps() {
		_classCallCheck(this, Maps);

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

	_createClass(Maps, {
		addLegend: {

			/**
    * Display a legend
    *
    * @return void
    */

			value: function addLegend() {

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
		},
		addMarkers: {

			/**
    * Add bunch of markers.
    *
    * @return void
    */

			value: function addMarkers() {
				//var serializedLocations = null; // debug
				var serializedLocations = sessionStorage.getItem("EasyvoteLocation.Locations");

				// If we don't have the points in Session Storage, fetch them by Ajax.
				if (!$.cookie("isDataValid") || !serializedLocations) {
					$.ajax({
						url: "/routing/locations" + "?L=" + EasyvoteLocation.Language + "&cid=" + EasyvoteLocation.ContentElementUid,
						async: true,
						cache: true,
						success: function success(locations) {

							// Store data for the session
							sessionStorage.setItem("EasyvoteLocation.Locations", JSON.stringify(locations));

							Maps.getInstance().createMarkers(locations);

							$.cookie("isDataValid", "true", { expires: Cookie.getCookieLifeTime() });
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
		},
		createMarkers: {

			/**
    * Add bunch of markers.
    *
    * @param {array} locations
    * @return void
    */

			value: function createMarkers(locations) {

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
		},
		computeIcon: {

			/**
    * @param {Object} location
    * @return string
    */

			value: function computeIcon(location) {
				// Remove the trailing ".png" extension
				var iconBasePath = EasyvoteLocation.LocationTypes[location.type].icon.replace(".png", "");
				if (!location.active) {
					iconBasePath += "Gray";
				}
				// Only for vote events
				//if (location.hasEvent) {
				//	iconBasePath += "Event";
				//}
				return iconBasePath + ".png";
			}
		},
		createMarker: {

			/**
    * @param location
    * @return google.maps.Marker
    */

			value: function createMarker(location) {
				var marker = new google.maps.Marker({
					id: location.id,
					position: new google.maps.LatLng(location.latitude, location.longitude),
					icon: this.computeIcon(location)
					//map: map
				});

				var boxWidth = 300;
				var loading = "<img src=\"/typo3conf/ext/easyvote_location/Resources/Public/Icons/loading.gif\" alt=\"\" />";
				var infoBox = new InfoBox({
					content: "<div class=\"maps-infoBox\" style=\"text-align: center\">" + loading + "</div>",
					pixelOffset: new google.maps.Size(boxWidth / 2 * -1, -40),
					alignBottom: true,
					disableAutoPan: true,
					boxStyle: {
						width: boxWidth + "px"
					},
					closeBoxMargin: "5px",
					closeBoxURL: "/typo3conf/ext/easyvote_location/Resources/Public/Icons/Close.png",
					infoBoxClearance: new google.maps.Size(50, 250),
					enableEventPropagation: false
				});

				google.maps.event.addListener(marker, "click", function () {

					// close previous opened info window
					if (Maps.getInstance().getInfoWindowReference()) {
						Maps.getInstance().getInfoWindowReference().close();
					}
					Maps.getInstance().setInfoWindowReference(infoBox);

					infoBox.open(this.map, this);

					// Additional listener in case the infoBox
					// is still opening if / when the answer of the server is slow.
					google.maps.event.addListener(infoBox, "domready", function () {
						var markerPixel = infoBox.getProjection().fromLatLngToContainerPixel(infoBox.getPosition());
						var centerPixel = infoBox.getProjection().fromLatLngToContainerPixel(this.map.getCenter());

						var correction = 150; // correction so that the bubble is displayed in the map
						var moveX = (centerPixel.x - markerPixel.x) * -1;
						var moveY = (centerPixel.y - markerPixel.y) * -1 - correction;
						this.map.panBy(moveX, moveY);

						var isMissingContent = infoBox.getContent().match("loading.gif");
						if (isMissingContent) {
							$.ajax({
								url: "/routing/locations/" + marker.id + "?L=" + EasyvoteLocation.Language + "&cid=" + EasyvoteLocation.ContentElementUid,
								success: function success(location) {
									var content = "<div class=\"maps-infoBox\">" + location.description + "</div>";
									infoBox.setContent(content);
								}
							});
						}
					});
				});

				return marker;
			}
		},
		addFullScreenCapability: {

			/**
    * @return void
    */

			value: function addFullScreenCapability() {
				// Save with and height for full screen mode
				var googleMapWidth = $("#map-container").css("width");
				var googleMapHeight = $("#map-container").css("height");
				var canvasHeight = $("#map-canvas").css("height");

				$("#btn-enter-full-screen").click(function () {
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
						height: $(window).height() - 25 + "px"
					});

					google.maps.event.trigger(Maps.getInstance().getMap(), "resize");

					// Gui
					$("#sitefooter").hide();
					$("#btn-enter-full-screen").toggle();
					$("#btn-exit-full-screen").toggle();
					return false;
				});

				$("#btn-exit-full-screen").click(function () {

					$("#map-container").css({
						position: "relative",
						top: 0,
						//left: 0,
						width: googleMapWidth,
						height: googleMapHeight,
						backgroundColor: "transparent"
					});

					$("#map-canvas").css({
						height: canvasHeight
					});

					google.maps.event.trigger(Maps.getInstance().getMap(), "resize");

					// Gui
					$("#sitefooter").show();
					$("#btn-enter-full-screen").toggle();
					$("#btn-exit-full-screen").toggle();
					return false;
				});
			}
		},
		getMap: {

			/**
    * @returns google.maps.Map
    */

			value: function getMap() {
				return this.map;
			}
		},
		getInfoWindowReference: {

			/**
    * @returns InfoBox
    */

			value: function getInfoWindowReference() {
				return this.infoWindowReference;
			}
		},
		setInfoWindowReference: {

			/**
    * @param {InfoBox} infoWindowReference
    */

			value: function setInfoWindowReference(infoWindowReference) {
				this.infoWindowReference = infoWindowReference;
			}
		}
	}, {
		getInstance: {

			/**
    * Class Factory
    *
    * @return Maps
    */

			value: function getInstance() {
				if (!this.instance) {
					this.instance = new Maps();
				}
				return this.instance;
			}
		}
	});

	return Maps;
})();

module.exports = Maps;
},{"./Cookie.js":2,"./GeoLocation.js":3,"babel-runtime/helpers/class-call-check":7,"babel-runtime/helpers/create-class":8,"babel-runtime/helpers/interop-require":9}],5:[function(require,module,exports){
"use strict";

var _classCallCheck = require("babel-runtime/helpers/class-call-check")["default"];

var _createClass = require("babel-runtime/helpers/create-class")["default"];

var Responsive = (function () {

	/**
  * Constructor
  */

	function Responsive() {
		_classCallCheck(this, Responsive);

		this.reference = jRespond([{
			label: "mobile",
			enter: 0,
			exit: 991
		}, {
			label: "desktop",
			enter: 992,
			exit: 10000
		}]);
	}

	_createClass(Responsive, {
		bindAction: {

			/**
    * @return void
    */

			value: function bindAction() {
				this.reference.addFunc({
					breakpoint: "mobile",
					enter: function enter() {
						EasyvoteLocation.originalWrapperFilter = $("#wrapper-filter");
						EasyvoteLocation.originalWrapperFilterParentContent = EasyvoteLocation.originalWrapperFilter.closest(".csc-default");
						var $form = EasyvoteLocation.originalWrapperFilter.parent().detach();
						$("#container-mobile").append($form);
					},
					exit: function exit() {
						var $form = $("#container-mobile").find(".tx-easyvote-location").detach();
						EasyvoteLocation.originalWrapperFilterParentContent.append($form);
					}
				});
			}
		}
	});

	return Responsive;
})();

module.exports = Responsive;
},{"babel-runtime/helpers/class-call-check":7,"babel-runtime/helpers/create-class":8}],6:[function(require,module,exports){
"use strict";

var _classCallCheck = require("babel-runtime/helpers/class-call-check")["default"];

var _interopRequire = require("babel-runtime/helpers/interop-require")["default"];

var Maps = _interopRequire(require("./Maps.js"));

var SearchForm =

/**
 * Constructor
 */
function SearchForm() {
	_classCallCheck(this, SearchForm);

	$(".communityUser-citySelection").select2({
		placeholder: EasyvoteLabels.enterZipOrCity,
		minimumInputLength: 2,
		ajax: {
			url: "/?eID=easyvote_cityselection",
			dataType: "json",
			data: function data(term, page) {
				return {
					q: term // search term
				};
			},
			results: function results(data, page) {
				return { results: data.results };
			}
		},
		initSelection: function initSelection(element, callback) {},
		dropdownCssClass: "bigdrop",
		escapeMarkup: function escapeMarkup(m) {
			return m;
		}
	}).on("change", function (e) {
		var data = $(this).select2("data");
		Maps.getInstance().getMap().setCenter(new google.maps.LatLng(data.latitude, data.longitude));
		Maps.getInstance().getMap().setZoom(14);
	});
};

module.exports = SearchForm;

//callback({ id: initialValue, text: initialValue });
},{"./Maps.js":4,"babel-runtime/helpers/class-call-check":7,"babel-runtime/helpers/interop-require":9}],7:[function(require,module,exports){
"use strict";

exports["default"] = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

exports.__esModule = true;
},{}],8:[function(require,module,exports){
"use strict";

exports["default"] = (function () {
  function defineProperties(target, props) {
    for (var key in props) {
      var prop = props[key];
      prop.configurable = true;
      if (prop.value) prop.writable = true;
    }

    Object.defineProperties(target, props);
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
})();

exports.__esModule = true;
},{}],9:[function(require,module,exports){
"use strict";

exports["default"] = function (obj) {
  return obj && obj.__esModule ? obj["default"] : obj;
};

exports.__esModule = true;
},{}]},{},[1]);
