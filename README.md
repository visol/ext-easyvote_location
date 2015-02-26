EasyVote Location
=================

TYPO3 CMS extension for displaying voting locations on a map.


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