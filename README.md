EasyVote Location
=================

TYPO3 CMS extension for displaying voting locations on a map.

Features
--------

* Maps is centered and zoomed to the selected locality if the FE User is authenticated.
* Icons of the Markers are displayed differently according to the voting possibility (next voting day)
* A User can search for Voting station given a search form.

Info
----

* There are two level of caches configured for the Map plugin. On the (1) server side, the cache is configured as "FileBackend"
  to store the list of voting locations in a JSON file which enables fast delivery of the content.
  On the (2) client side, the voting locations is stored in the Session storage which means it won't query the server twice once
  the locations have been loaded.
* The cache expires at 0,30 minutes for both, server and client.


Location types
--------------

- Post boxes (Briefkasten) → UserEditable: FALSE
- Municipal administrations (Gemeindeverwaltung) → UserEditable: TRUE
- Polling stations (Wahllokal) → UserEditable: TRUE


Build assets
------------

Source is located at `Resources/Public/JavaScript/App/*.js`. Grunt will watch the files and generate as editing the build file into
`Resources/Public/JavaScript/Build/Bundle.js`. To start watching.

```
	npm install
	grunt watch

```


Command Line Interface
----------------------

To import the Post Boxes

	./typo3/cli_dispatch.phpsh extbase postbox:import --file ~/Files/PostBoxes.xml


Unit Test
---------

Guidance for running the Unit Test in this extension

```

	# Install the PHPUnit Framework
	cd typo3_src
	composer install

	# Run the test
	typo3_src/bin/phpunit --colors -c typo3/sysext/core/Build/UnitTests.xml typo3conf/ext/easyvote_location/Tests/Unit
```
