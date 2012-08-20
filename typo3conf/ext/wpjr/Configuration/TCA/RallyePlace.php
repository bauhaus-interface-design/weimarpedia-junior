<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wpjr_domain_model_rallyeplace'] = array(
	'ctrl' => $TCA['tx_wpjr_domain_model_rallyeplace']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'name,description,image,address,lat,lng,accuracy',
	),
	'types' => array(
		'1' => array('showitem'	=> 'name,description,image,address,lat,lng,accuracy'),
	),
	'palettes' => array(
		'1' => array('showitem'	=> ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude'			=> 1,
			'label'				=> 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config'			=> array(
				'type'					=> 'select',
				'foreign_table'			=> 'sys_language',
				'foreign_table_where'	=> 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
				),
			)
		),
		'l18n_parent' => array(
			'displayCond'	=> 'FIELD:sys_language_uid:>:0',
			'exclude'		=> 1,
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config'		=> array(
				'type'			=> 'select',
				'items'			=> array(
					array('', 0),
				),
				'foreign_table' => 'tx_wpjr_domain_model_rallyeplace',
				'foreign_table_where' => 'AND tx_wpjr_domain_model_rallyeplace.uid=###REC_FIELD_l18n_parent### AND tx_wpjr_domain_model_rallyeplace.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'		=>array(
				'type'		=>'passthrough',
			)
		),
		't3ver_label' => array(
			'displayCond'	=> 'FIELD:t3ver_label:REQ:true',
			'label'			=> 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config'		=> array(
				'type'		=>'none',
				'cols'		=> 27,
			)
		),
		'hidden' => array(
			'exclude'	=> 1,
			'label'		=> 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'	=> array(
				'type'	=> 'check',
			)
		),
		'name' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.name',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.description',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'image' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.image',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.address',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lat' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.lat',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'lng' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.lng',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'accuracy' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace.accuracy',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'task' => array(
			'config' => array(
				'type'	=> 'passthrough',
			),
		),
	),
);
?>