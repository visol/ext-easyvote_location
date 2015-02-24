<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_easyvotelocation_domain_model_locationtype'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_easyvotelocation_domain_model_locationtype']['ctrl'],
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, icon, description, is_content_editable,'),
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
				'foreign_table' => 'tx_easyvotelocation_domain_model_locationtype',
				'foreign_table_where' => 'AND tx_easyvotelocation_domain_model_locationtype.pid=###CURRENT_PID### AND tx_easyvotelocation_domain_model_locationtype.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_locationtype.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'icon' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_locationtype.icon',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'icon',
				array('maxitems' => 1)
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_locationtype.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'is_content_editable' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:easyvote_location/Resources/Private/Language/locallang_db.xlf:tx_easyvotelocation_domain_model_locationtype.is_content_editable',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
	),
);
