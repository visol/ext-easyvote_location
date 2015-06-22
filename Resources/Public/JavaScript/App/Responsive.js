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
				let $form = $('#c3160').find('form').contents().parent().detach();
				$('#container-mobile .content-box').append($form);
			},
			exit: function exit() {
				let $form = $('#container-mobile .content-box').find('form').parent().contents().detach();
				$('#c3160 .content-box').append($form);
			}
		});
	}
}

export default Responsive;