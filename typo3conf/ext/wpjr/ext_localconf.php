<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Rallye' => 'list,create,edit,update,delete , listTasks,createTask,updateTask,deleteTask,sortTasks , export, listJson, activate, deactivate',
		'RallyePlace' => 'list,create,show,update,delete',
		'Result' => 'list,create,show,update,delete,import,report,present'
	),
	array(
		
	)
);
?>