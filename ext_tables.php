<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	// Register plugins in the BE.
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'easyvote_location',
		'Pi1',
		'easyvote Location: Voting locations on a map'
	);

	$TCA['tt_content']['types']['list']['subtypes_addlist']['easyvotelocation_pi1'] = 'pi_flexform';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
		'easyvotelocation_pi1',
		'FILE:EXT:easyvote_location/Configuration/FlexForm/location.xml'
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'easyvote_location',
		'Pi2',
		'easyvote Location: Locality search form'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_location');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_easyvotelocation_domain_model_locationtype');
}

