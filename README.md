EasyVote Location
=================

TYPO3 CMS extension for displaying voting locations on a map.

TODO
----

* Static TypoScript to load in easyvote
* Check if Localization for Location could be avoided.

Features
--------

* Maps is centered and zoomed to the selected locality if the FE User is authenticated.
* Icons of the Markers are displayed differently according to the voting possibility (next voting day)
* A User can search for Voting station given a serch form.

Location types
--------------

- Post boxes (Briefkasten) → UserEditable: FALSE
- Municipal administrations (Gemeindeverwaltung) → UserEditable: TRUE
- Polling stations (Wahllokal) → UserEditable: TRUE


Command Line Interface
----------------------

To import the Post Boxes

	./typo3/cli_dispatch.phpsh extbase postbox:import --file ~/Files/PostBoxes.xml


SQL server configuration
------------------------

To enable caching of locations markers, the SQL server must be configured to access large set of packets:


```
	[mysqld]

	max_allowed_packet = 10M

```