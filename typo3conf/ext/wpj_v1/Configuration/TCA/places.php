<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpjv1_domain_model_places'] = array(
	'ctrl' => $TCA['tx_wpjv1_domain_model_places']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'parent_id,tx_wpjv1_label,lat,lng,coordinates,reviewed'
	),
	'types' => array(
		'1' => array('showitem' => 'parent_id,tx_wpjv1_label,lat,lng,coordinates,reviewed')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_wpjv1_domain_model_places',
				'foreign_table_where' => 'AND tx_wpjv1_domain_model_places.uid=###REC_FIELD_l18n_parent### AND tx_wpjv1_domain_model_places.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'parent_id' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.parent_id',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'tx_wpjv1_label' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.tx_wpjv1_label',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'lat' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.lat',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'lng' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.lng',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'coordinates' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.coordinates',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'reviewed' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places.reviewed',
			'config'  => array(
				'type' => 'check',
				'default' => 0
			)
		),
	),
);
?>