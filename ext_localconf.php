<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Visol.' . $_EXTKEY,
	'Pi1',
	array(
		'Location' => 'index',
		'LocationApi' => 'list',

	),
	// non-cacheable actions
	array(
		'Location' => 'index', // @todo remove me!?
		'LocationApi' => 'list',
	)
);


// Configure commands that can be run from the cli_dispatch.phpsh script.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Visol\EasyvoteLocation\Command\PostBoxCommandController';
