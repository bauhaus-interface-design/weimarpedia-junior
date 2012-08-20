<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'WPJ_V1'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'WPJ_V1');

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');


t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_article','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_article.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_article');
$TCA['tx_wpjv1_domain_model_article'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_article',
		'label' 			=> 'article_type',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/article.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_article.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_places','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_places.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_places');
$TCA['tx_wpjv1_domain_model_places'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_places',
		'label' 			=> 'parent_id',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/places.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_places.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_tag','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_tag.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_tag');
$TCA['tx_wpjv1_domain_model_tag'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_tag',
		'label' 			=> 'caption',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tag.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_tag.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_media','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_media.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_media');
$TCA['tx_wpjv1_domain_model_media'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_media',
		'label' 			=> 'content_type',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/media.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_media.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_user','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_user.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_user');
$TCA['tx_wpjv1_domain_model_user'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_user',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/user.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_user.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_concept','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_concept.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_concept');
$TCA['tx_wpjv1_domain_model_concept'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_concept',
		'label' 			=> 'caption',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/concept.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_concept.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjv1_domain_model_articletype','EXT:wpj_v1/Resources/Private/Language/locallang_csh_tx_wpjv1_domain_model_articletype.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjv1_domain_model_articletype');
$TCA['tx_wpjv1_domain_model_articletype'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj_v1/Resources/Private/Language/locallang_db.xml:tx_wpjv1_domain_model_articletype',
		'label' 			=> 'caption',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/articletype.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjv1_domain_model_articletype.gif'
	)
);

?>