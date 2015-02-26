<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'easyvote_location',
	'Pi1',
	'easyvote Location: Display voting locations on a map'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('easyvote_location', 'Configuration/TypoScript', 'Voting point location');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_location');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_locationtype');

