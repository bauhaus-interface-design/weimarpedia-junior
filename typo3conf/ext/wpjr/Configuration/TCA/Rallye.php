<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wpjr_domain_model_rallye'] = array(
	'ctrl' => $TCA['tx_wpjr_domain_model_rallye']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'name,description,comment,image,duration,author',
	),
	'types' => array(
		'1' => array('showitem'	=> 'name,description,comment,image,duration,author'),
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
				'foreign_table' => 'tx_wpjr_domain_model_rallye',
				'foreign_table_where' => 'AND tx_wpjr_domain_model_rallye.uid=###REC_FIELD_l18n_parent### AND tx_wpjr_domain_model_rallye.sys_language_uid IN (-1,0)',
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
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.name',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.description',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'comment' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.comment',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'image' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.image',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'duration' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.duration',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'author' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.author',
			'config'	=> array(
				'type' => 'inline',
				'foreign_table' => 'fe_users',
			),
		),
		
		'tasks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.tasks',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjr_domain_model_task',
				'foreign_field' => 'rallye',
				'foreign_sortby' => 'tx_wpjr_sorting',
				'maxitems'      => 999,
				'appearance' => array(
					'newRecordLinkPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		
		'active' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.active',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		
		'presentation' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye.presentation',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		
	),
);
?>