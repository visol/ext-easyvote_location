<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'easyvote_location',
	'Pi1',
	'easyvote Location: Display voting locations on a map'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_datamanager';
$TCA['tt_content']['types']['list']['subtypes_addlist']['easyvotelocation_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	'easyvotelocation_pi1',
	'FILE:EXT:easyvote_location/Configuration/FlexForm/location.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'easyvote_location',
	'Pi2',
	'easyvote Location: Search form locality and zoom the map'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_location');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_locationtype');

