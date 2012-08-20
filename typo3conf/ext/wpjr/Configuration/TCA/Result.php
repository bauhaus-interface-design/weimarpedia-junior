<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wpjr_domain_model_result'] = array(
	'ctrl' => $TCA['tx_wpjr_domain_model_result']['ctrl'],
	'interface' => array(
		'showRecordFieldList'	=> 'user,content,timestamp,task',
	),
	'types' => array(
		'1' => array('showitem'	=> 'user,content,timestamp,task'),
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
				'foreign_table' => 'tx_wpjr_domain_model_result',
				'foreign_table_where' => 'AND tx_wpjr_domain_model_result.uid=###REC_FIELD_l18n_parent### AND tx_wpjr_domain_model_result.sys_language_uid IN (-1,0)',
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
		'user' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.user',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'content' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.content',
			'config'	=> array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'timestamp' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.timestamp',
			'config'	=> array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'task' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.task',
			'config'	=> array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjr_domain_model_task',
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
		'rallye' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.task',
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
		'login' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.content',
			'config'	=> array(
				'type' => 'input',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'groupname' => array(
			'exclude'	=> 0,
			'label'		=> 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result.content',
			'config'	=> array(
				'type' => 'input',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
	),
);
?>