<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'dashboard' => 'index,index_loggedIn',
		'search' => 'index',
		'article' => 'index, exhibition, show, new, create, edit, update, delete, addTag, removeTag,suggestTag,suggestTagPlace,loadPlaceChildren, placeSelectForm,refPlaceSelectForm,loadTagBox, loadMediaBox, loadMapBox, loadMapXml, loadAuthorsBox, removeAuthor, loadVersionsBox, compareVersions, indexByTag, indexByAuthor,indexBySchool, addMedia, addMediafile, removeMedia, uploadMediafile, setReview,search, closeFancyBox, suggestArticle',
		'place' => 'index,tree,loadChildren, show, new, create, edit, update, delete, loadChildOptions, loadPathToRootOptions,createPlaces',
		'tag' => 'index, show, new, create, edit, update, delete',
		'media' => 'index, show, new, create, edit, update, delete',
		'session' => 'loginForm, login, logout',
		'account' => 'index, edit, update, avatarForm, uploadAvatarRaw, uploadAvatarFile',
		'author' => 'index, show, new, create, edit, update, delete, updatePassword',
		'mediafile' => 'index, show, new, create, edit, update, delete',
		'map' => 'index,search,suggest,loadPlaces,placeArticles,listPlaceOptions,listFloorOptions,listRoomArticles,showArticle',
		'articleAdmin' => 'index,indexKnowledge,indexExhibition,indexLastModified,indexNotReviewed,delete,backupWizard,setVoting',
		'mapAdmin' => 'index,delete,loadChildren,loadBuildings,savePolygone',
		'school' => 'index, show, new, create, edit, update, delete',
		'authorWizard' => 'step1,step1Select,step1Create,step2,step2Process,step3,step3Process',
	),
	array(
		'article' => 'ajax,create, update, delete','places' => 'create, update, delete','tag' => 'create, update, delete','media' => 'create, update, delete','user' => 'create, update, delete',
	)
);

?>