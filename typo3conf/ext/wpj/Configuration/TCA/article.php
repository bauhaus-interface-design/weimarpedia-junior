<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpj_domain_model_article'] = array(
	'ctrl' => $TCA['tx_wpj_domain_model_article']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,body,reviewed,tags,medias,articletype,authors'
	),
	'types' => array(
		'1' => array('showitem' => 'title,body,reviewed,tags,medias,articletype,authors')
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
				'foreign_table' => 'tx_wpj_domain_model_article',
				'foreign_table_where' => 'AND tx_wpj_domain_model_article.uid=###REC_FIELD_l18n_parent### AND tx_wpj_domain_model_article.sys_language_uid IN (-1,0)',
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
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'body' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.body',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'reviewed' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.reviewed',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'tags' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.tags',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpj_domain_model_tag',
				'MM' => 'tx_wpj_article_tag_mm',
				'maxitems' => 99999
			)
		),
		'medias' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.medias',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpj_domain_model_media',
				'MM' => 'tx_wpj_article_media_mm',
				'maxitems' => 99999
			)
		),
		'articletype' => array(
			'exclude' => 0,
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpj_domain_model_articletype',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'voting' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.voting',
			'config'  => array(
				'type' => 'input',
				'size' => 2,
				'eval' => 'trim,required'
			)
		),
		'authors' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article.authors',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'fe_users',
				'MM' => 'tx_wpj_article_author_mm',
				'maxitems' => 99999
			)
		),
        't3ver_id' => Array (
            'exclude' => 1,
            'label' => 'Version',
            'config' => Array (
                'type' => 'none',
            )
        ),
		'crdate' => Array (
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
        
            )
        ), 
        'tstamp' => Array (
            'exclude' => 1,
            'label' => 'Modification date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
        
            )
        ),
	),
);
?>