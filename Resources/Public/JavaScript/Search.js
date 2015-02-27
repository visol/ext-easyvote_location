if (typeof postalCodeServiceUrl === 'string') {
	var $postalCodeSelector = $(".communityUser-citySelection");
	$postalCodeSelector.select2({
		placeholder: EasyVote.PlaceholderPostalCode,
		minimumInputLength: 2,
		ajax: {
			url: postalCodeServiceUrl,
			dataType: 'json',
			data: function(term, page) {
				return {
					q: term // search term
				};
			},
			results: function(data, page) {
				return {results: data.results};
			}
		},
		initSelection: function(element, callback) {
			//callback({ id: initialValue, text: initialValue });
		},
		dropdownCssClass: "bigdrop",
		escapeMarkup: function(m) {
			return m;
		}
	}).on('change', function(e) {
		var data = $(this).select2('data');
		map.setCenter(new google.maps.LatLng(data.latitude, data.longitude));
		map.setZoom(14);
	});
}