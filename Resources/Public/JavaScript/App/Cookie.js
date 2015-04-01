class Cookie {

	/**
	 * Cookie expires every 0, 30 minutes
	 *
	 * @return {Date}
	 */
	static getCookieLifeTime() {

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

export default Cookie;