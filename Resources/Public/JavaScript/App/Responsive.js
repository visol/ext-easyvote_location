class Responsive {

	/**
	 * Constructor
	 */
	constructor () {
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

	/**
	 * @return void
	 */
	bindAction () {
		this.reference.addFunc({
			breakpoint: "mobile",
			enter: function enter() {
				EasyvoteLocation.originalWrapperFilter = $('#wrapper-filter');
				EasyvoteLocation.originalWrapperFilterParentContent = EasyvoteLocation.originalWrapperFilter.closest('.csc-default');
				let $form = EasyvoteLocation.originalWrapperFilter.parent().detach();
				$('#container-mobile').append($form);
			},
			exit: function exit() {
				let $form = $('#container-mobile').find('.tx-easyvote-location').detach();
				EasyvoteLocation.originalWrapperFilterParentContent.append($form);
			}
		});
	}
}

export default Responsive;