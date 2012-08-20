<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpjv1_domain_model_media'] = array(
	'ctrl' => $TCA['tx_wpjv1_domain_model_media']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'content_type,file'
	),
	'types' => array(
		'1' => array('showitem' => 'content_type,file')
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
				'foreign_table' => 'tx_wpjv1_domain_model_media',
				'foreign_table_where' => 'AND tx_wpjv1_domain_model_media.uid=###REC_FIELD_l18n_parent### AND tx_wpjv1_domain_model_media.sys_language_uid IN (-1,0)',
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
		'content_type' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_media.content_type',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'file' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_media.file',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
	),
);
?>