<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'WPJ'
); 

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'WPJ');

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');


t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_article','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_article.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_article');
$TCA['tx_wpj_domain_model_article'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_article',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> TRUE,
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
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_article.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_place','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_place.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_place');
$TCA['tx_wpj_domain_model_place'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_place',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/place.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_place.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_tag','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_tag.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_tag');
$TCA['tx_wpj_domain_model_tag'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_tag',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tag.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_tag.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_media','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_media.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_media');
$TCA['tx_wpj_domain_model_media'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_media',
		'label' 			=> 'description',
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
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_media.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_author','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_author.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_author');
$TCA['tx_wpj_domain_model_author'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_author',
		'label' 			=> 'login',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/author.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_author.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_articletype','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_articletype.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_articletype');
$TCA['tx_wpj_domain_model_articletype'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_articletype',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/articletype.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_articletype.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_schooltype','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_school_type.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_school_type');
$TCA['tx_wpj_domain_model_schooltype'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_schooltype',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/schooltype.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_schooltype.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_school','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_school.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_school');
$TCA['tx_wpj_domain_model_school'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_school',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/school.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_school.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_taxonomy','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_taxonomy.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_taxonomy');
$TCA['tx_wpj_domain_model_taxonomy'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_taxonomy',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/taxonomy.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_taxonomy.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpj_domain_model_mediafile','EXT:wpj/Resources/Private/Language/locallang_csh_tx_wpj_domain_model_mediafile.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpj_domain_model_mediafile');
$TCA['tx_wpj_domain_model_mediafile'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpj/Resources/Private/Language/locallang_db.xml:tx_wpj_domain_model_mediafile',
		'label' 			=> 'title',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/mediafile.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpj_domain_model_mediafile.gif'
	)
);

t3lib_div::loadTCA('fe_users');


?>