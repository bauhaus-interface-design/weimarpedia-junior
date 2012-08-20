<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpj_domain_model_place'] = array(
	'ctrl' => $TCA['tx_wpj_domain_model_place']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,lat,lng,coordinates,reviewed,accuracy,description,parent'
	),
	'types' => array(
		'1' => array('showitem' => 'name,lat,lng,coordinates,reviewed,accuracy,description,parent')
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
				'foreign_table' => 'tx_wpj_domain_model_place',
				'foreign_table_where' => 'AND tx_wpj_domain_model_place.uid=###REC_FIELD_l18n_parent### AND tx_wpj_domain_model_place.sys_language_uid IN (-1,0)',
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
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'lat' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.lat',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'lng' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.lng',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'coordinates' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.coordinates',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'image' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.image',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'icon' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.image',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'reviewed' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.reviewed',
			'config'  => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'accuracy' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.accuracy',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'parent' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place.parent',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpj_domain_model_place',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
	),
);
?>