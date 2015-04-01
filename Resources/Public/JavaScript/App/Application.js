"use strict";

// Initialize the map.
import Maps from './Maps.js'
google.maps.event.addDomListener(window, "load", function() {
	Maps.getInstance();
});

// Initialize the search form.
import SearchForm from './SearchForm.js'
var search = new SearchForm();

// Add some responsiveness feature such as the search form
// which should be displayed elsewhere in the mobile layout.
import Responsive from './Responsive.js'
var responsive = new Responsive();
responsive.bindAction();
