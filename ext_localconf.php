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


// Register cache
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location'] = array();
}

// Override default Variable Frontend Cache to be String
if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['frontend'])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['frontend'] = 'TYPO3\CMS\Core\Cache\Frontend\StringFrontend';
}

// Register the cache table to be deleted when general caches is hit.
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['cf_easyvote_location'] = 'cf_easyvote_location';
