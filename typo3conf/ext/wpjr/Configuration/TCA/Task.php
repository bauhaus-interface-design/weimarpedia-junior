<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wpjr_domain_model_task'] = array(
	'ctrl' => $TCA['tx_wpjr_domain_model_task']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'parent,tx_wpjr_sorting,title,intro,instruction,image1,image2,image3,image4,duration,resulttype,resultoptions,resultrequired,rallye,place',
	),
	'types' => array(
		'1' => array('showitem'	=> 'parent,tx_wpjr_sorting,title,intro,instruction,image1,image2,image3,image4,duration,resulttype,resultoptions,resultrequired,rallye,place'),
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
				'foreign_table' => 'tx_wpjr_domain_model_task',
				'foreign_table_where' => 'AND tx_wpjr_domain_model_task.uid=###REC_FIELD_l18n_parent### AND tx_wpjr_domain_model_task.sys_language_uid IN (-1,0)',
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
		'parent' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.parent',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'tx_wpjr_sorting' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.tx_wpjr_sorting',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'title' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.title',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'intro' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.intro',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'instruction' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.instruction',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim,required'
			),
		),
		'image1' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.image1',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'image2' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.image2',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'image3' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.image3',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'image4' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.image4',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'duration' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.duration',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'resulttype' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.resulttype',
			'config'	=> array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'resultoptions' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.resultoptions',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'resultrequired' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.resultrequired',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'rallye' => array(
			'exclude'	=> 1,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.rallye',
			'config'	=> array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjr_domain_model_rallye',
				'maxitems'      => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'place' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task.place',
			'config'	=> array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjr_domain_model_rallyeplace',
				'minitems' => 0,
				'maxitems'      => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'result' => array(
			'config' => array(
				'type'	=> 'passthrough',
			),
		),
	),
);
?>