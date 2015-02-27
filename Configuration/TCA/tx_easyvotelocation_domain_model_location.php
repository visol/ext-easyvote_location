<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_easyvotelocation_domain_model_location'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'name,address,longitude,latitude,city,creator,last_updater,description,is_available_for_current_voting_day,photo,location_type,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('easyvote_location') . 'Configuration/TCA/Location.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('easyvote_location') . 'Resources/Public/Icons/tx_easyvotelocation_domain_model_location.gif'
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, address, longitude, latitude, city, creator, last_updater, description, is_available_for_current_voting_day, photo, location_type, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_easyvotelocation_domain_model_location',
				'foreign_table_where' => 'AND tx_easyvotelocation_domain_model_location.pid=###CURRENT_PID### AND tx_easyvotelocation_domain_model_location.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'longitude' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'latitude' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'creator' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.creator',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_updater' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.last_updater',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'is_available_for_current_voting_day' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.is_available_for_current_voting_day',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'photo' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.photo',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'photo',
				array('maxitems' => 1)
			),
		),
		'location_type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_location.location_type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_easyvotelocation_domain_model_locationtype',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'locationtype' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		'street' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'zip' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_1' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_2' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_3' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_4' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_6' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'emptying_time_day_7' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
