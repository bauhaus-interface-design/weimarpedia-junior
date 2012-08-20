<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');


Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'WPJR'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'WPJ Rallye');




t3lib_extMgm::addLLrefForTCAdescr('tx_wpjr_domain_model_rallye', 'EXT:wpjr/Resources/Private/Language/locallang_csh_tx_wpjr_domain_model_rallye.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjr_domain_model_rallye');
$TCA['tx_wpjr_domain_model_rallye'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallye',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Rallye.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjr_domain_model_rallye.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjr_domain_model_task', 'EXT:wpjr/Resources/Private/Language/locallang_csh_tx_wpjr_domain_model_task.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjr_domain_model_task');
$TCA['tx_wpjr_domain_model_task'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_task',
		'label' 			=> 'parent',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Task.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjr_domain_model_task.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjr_domain_model_result', 'EXT:wpjr/Resources/Private/Language/locallang_csh_tx_wpjr_domain_model_result.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjr_domain_model_result');
$TCA['tx_wpjr_domain_model_result'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_result',
		'label' 			=> 'user',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Result.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjr_domain_model_result.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wpjr_domain_model_rallyeplace', 'EXT:wpjr/Resources/Private/Language/locallang_csh_tx_wpjr_domain_model_rallyeplace.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wpjr_domain_model_rallyeplace');
$TCA['tx_wpjr_domain_model_rallyeplace'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:wpjr/Resources/Private/Language/locallang_db.xml:tx_wpjr_domain_model_rallyeplace',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/RallyePlace.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wpjr_domain_model_rallyeplace.gif'
	)
);


?>