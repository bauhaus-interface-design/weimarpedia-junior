<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpj_domain_model_author'] = array(
	'ctrl' => $TCA['tx_wpj_domain_model_author']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'login,password,name,first_name,last_name'
	),
	'types' => array(
		'1' => array('showitem' => 'login,password,name,first_name,last_name')
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
				'foreign_table' => 'fe_users',
				//'foreign_table_where' => 'AND tx_wpj_domain_model_author.uid=###REC_FIELD_l18n_parent### AND tx_wpj_domain_model_author.sys_language_uid IN (-1,0)',
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
        'admin' => Array (
            'exclude' => 1,
            'label' => 'Admin',
            'config' => Array (
                'type' => 'none',        
            )
        ),
        'articles' => array(
			'exclude' => 0,
			//'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.articles',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpj_domain_model_article',
				'MM' => 'tx_wpj_article_author_mm',
				'maxitems' => 99999
			)
		),
	),
);
?>