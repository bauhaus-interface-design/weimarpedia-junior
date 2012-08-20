<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'article' => 'index, show, new, create, edit, update, delete, addTag, removeTag, showTags',
		'places' => 'index, show, new, create, edit, update, delete',
		'tag' => 'index, show, new, create, edit, update, delete',
		'media' => 'index, show, new, create, edit, update, delete',
		'user' => 'index, show, new, create, edit, update, delete',
		'concept' => 'index, show, new, create, edit, update, delete',
	),
	array(
		'article' => 'ajax,create, update, delete','places' => 'create, update, delete','tag' => 'create, update, delete','media' => 'create, update, delete','user' => 'create, update, delete',
	)
);




?>