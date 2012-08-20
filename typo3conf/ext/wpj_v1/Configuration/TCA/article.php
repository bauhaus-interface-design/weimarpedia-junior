<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_wpjv1_domain_model_article'] = array(
	'ctrl' => $TCA['tx_wpjv1_domain_model_article']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'article_type,title,body,places,tags,medias,type'
	),
	'types' => array(
		'1' => array('showitem' => 'article_type,title,body,places,tags,medias,type')
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
				'foreign_table' => 'tx_wpjv1_domain_model_article',
				'foreign_table_where' => 'AND tx_wpjv1_domain_model_article.uid=###REC_FIELD_l18n_parent### AND tx_wpjv1_domain_model_article.sys_language_uid IN (-1,0)',
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
		'article_type' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.article_type',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'body' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.body',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'places' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.places',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjv1_domain_model_places',
				'MM' => 'tx_wpjv1_article_places_mm',
				'maxitems' => 99999
			)
		),
		'tags' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.tags',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjv1_domain_model_tag',
				'MM' => 'tx_wpjv1_article_tag_mm',
				'maxitems' => 99999
			)
		),
		'medias' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.medias',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wpjv1_domain_model_media',
				'MM' => 'tx_wpjv1_article_media_mm',
				'maxitems' => 99999
			)
		),
		'type' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article.type',
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
		'tstamp' => Array (
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
        
            )
        )
	),
);
?>