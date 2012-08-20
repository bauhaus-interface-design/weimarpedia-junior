<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpjv1_domain_model_concept'] = array(
	'ctrl' => $TCA['tx_wpjv1_domain_model_concept']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'caption,article_type'
	),
	'types' => array(
		'1' => array('showitem' => 'caption,article_type')
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
				'foreign_table' => 'tx_wpjv1_domain_model_concept',
				'foreign_table_where' => 'AND tx_wpjv1_domain_model_concept.uid=###REC_FIELD_l18n_parent### AND tx_wpjv1_domain_model_concept.sys_language_uid IN (-1,0)',
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
		'caption' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_concept.caption',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'article_type' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_concept.article_type',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjv1_domain_model_articletype',
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