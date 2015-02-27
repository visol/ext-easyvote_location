<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Visol.easyvote_location',
	'Pi1',
	array(
		'Location' => 'index',

	),
	// non-cacheable actions
	array(
		'Location' => 'index', // @todo remove me!?
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Visol.easyvote_location',
	'Pi2',
	array(
		'Location' => 'search',
	),
	// non-cacheable actions
	array(
		'Location' => 'search', // @todo remove me!?
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Visol.easyvote_location',
	'Location',
	array(
		'LocationApi' => 'list, show',
	),
	// non-cacheable actions
	array(
		'LocationApi' => 'list, show',
	)
);


// Configure commands that can be run from the cli_dispatch.phpsh script.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Visol\EasyvoteLocation\Command\PostBoxCommandController';

// Register cache
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['easyvote_location'] = array();
}

// Override default Frontend Cache to be String instead of Variable
if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['frontend'])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['frontend'] = 'TYPO3\CMS\Core\Cache\Frontend\StringFrontend';
}

// Override default Backend Cache to be File instead of Database
if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['backend'])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['easyvote_location']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\FileBackend';
}

// Register the cache table to be deleted when general caches is hit.
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['cf_easyvote_location'] = 'cf_easyvote_location';

// Register global route
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['routing']['globalRoutes'][] = 'EXT:easyvote_location/Configuration/GlobalRoutes.yaml';