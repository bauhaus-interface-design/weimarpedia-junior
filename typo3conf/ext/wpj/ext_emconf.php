<?php

########################################################################
# Extension Manager/Repository config file for ext "wpj".
#
# Auto generated 12-01-2011 11:25
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'WPJ',
	'description' => 'Version 1.0
2010-12-04',
	'category' => 'plugin',
	'author' => '',
	'author_email' => '',
	'author_company' => '',
	'shy' => '',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/wpj/mediafiles',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:119:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"8ffd";s:14:"ext_tables.php";s:4:"4db5";s:14:"ext_tables.sql";s:4:"3ae9";s:24:"ext_typoscript_setup.txt";s:4:"d14e";s:16:"kickstarter.json";s:4:"1a94";s:40:"Classes/Controller/articleController.php";s:4:"68c1";s:39:"Classes/Controller/authorController.php";s:4:"2060";s:38:"Classes/Controller/loginController.php";s:4:"7489";s:42:"Classes/Controller/mediafileController.php";s:4:"c36c";s:38:"Classes/Controller/placeController.php";s:4:"9d89";s:39:"Classes/Controller/schoolController.php";s:4:"a411";s:37:"Classes/Domain/Model/CopyOfauthor.php";s:4:"ca4a";s:32:"Classes/Domain/Model/article.php";s:4:"30e4";s:37:"Classes/Domain/Model/articletype.php";s:4:"e124";s:31:"Classes/Domain/Model/author.php";s:4:"b8a4";s:30:"Classes/Domain/Model/media.php";s:4:"fae6";s:34:"Classes/Domain/Model/mediafile.php";s:4:"cf1f";s:30:"Classes/Domain/Model/place.php";s:4:"669a";s:31:"Classes/Domain/Model/school.php";s:4:"3180";s:36:"Classes/Domain/Model/schooltype.php";s:4:"c453";s:28:"Classes/Domain/Model/tag.php";s:4:"9e04";s:34:"Classes/Domain/Model/taxonomy.php";s:4:"bb8f";s:47:"Classes/Domain/Repository/articleRepository.php";s:4:"25d2";s:46:"Classes/Domain/Repository/authorRepository.php";s:4:"1ac3";s:49:"Classes/Domain/Repository/mediafileRepository.php";s:4:"5b54";s:45:"Classes/Domain/Repository/placeRepository.php";s:4:"9c91";s:46:"Classes/Domain/Repository/schoolRepository.php";s:4:"4e10";s:49:"Classes/Domain/Repository/taxonomyRepository.php";s:4:"6e2d";s:40:"Classes/ViewHelpers/SelectViewHelper.php";s:4:"14a1";s:44:"Classes/ViewHelpers/UserStatusViewHelper.php";s:4:"092e";s:29:"Configuration/TCA/article.php";s:4:"168a";s:34:"Configuration/TCA/articletype.php";s:4:"6cee";s:28:"Configuration/TCA/author.php";s:4:"747a";s:27:"Configuration/TCA/media.php";s:4:"f734";s:31:"Configuration/TCA/mediafile.php";s:4:"7a19";s:27:"Configuration/TCA/place.php";s:4:"478f";s:28:"Configuration/TCA/school.php";s:4:"e4fc";s:33:"Configuration/TCA/schooltype.php";s:4:"90f5";s:25:"Configuration/TCA/tag.php";s:4:"1e9c";s:31:"Configuration/TCA/taxonomy.php";s:4:"7b7b";s:33:"Configuration/TypoScript/ajax.txt";s:4:"33c2";s:34:"Configuration/TypoScript/setup.txt";s:4:"f83e";s:40:"Resources/Private/Language/locallang.xml";s:4:"c5c5";s:72:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_article.xml";s:4:"7742";s:77:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_articletype.xml";s:4:"3cb7";s:71:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_author.xml";s:4:"8840";s:70:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_media.xml";s:4:"5448";s:74:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_mediafile.xml";s:4:"c3a4";s:70:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_place.xml";s:4:"9dcd";s:71:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_school.xml";s:4:"6062";s:76:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_schooltype.xml";s:4:"c60a";s:68:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_tag.xml";s:4:"d01c";s:74:"Resources/Private/Language/locallang_csh_tx_wpj_domain_model_taxonomy.xml";s:4:"1176";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"eda2";s:38:"Resources/Private/Layouts/default.html";s:4:"7a28";s:38:"Resources/Private/Layouts/default.ipad";s:4:"f217";s:42:"Resources/Private/Layouts/modalwindow.html";s:4:"2f45";s:47:"Resources/Private/Partials/articleListView.html";s:4:"c82c";s:38:"Resources/Private/Partials/footer.html";s:4:"53a8";s:42:"Resources/Private/Partials/formErrors.html";s:4:"f5bc";s:48:"Resources/Private/Partials/navigation_admin.html";s:4:"cc53";s:46:"Resources/Private/Partials/navigation_top.html";s:4:"5f52";s:52:"Resources/Private/Partials/navigation_top_right.html";s:4:"0cc5";s:39:"Resources/Private/Partials/sidebar.html";s:4:"c968";s:43:"Resources/Private/Partials/videoPlayer.html";s:4:"3180";s:49:"Resources/Private/Templates/article/addMedia.html";s:4:"6af2";s:53:"Resources/Private/Templates/article/addMediafile.html";s:4:"1755";s:47:"Resources/Private/Templates/article/addTag.html";s:4:"a80e";s:46:"Resources/Private/Templates/article/index.html";s:4:"0ca7";s:46:"Resources/Private/Templates/article/index.ipad";s:4:"b754";s:54:"Resources/Private/Templates/article/indexByAuthor.html";s:4:"c0b4";s:51:"Resources/Private/Templates/article/indexByTag.html";s:4:"b7c4";s:55:"Resources/Private/Templates/article/loadAuthorsBox.html";s:4:"af7e";s:51:"Resources/Private/Templates/article/loadMapBox.html";s:4:"01af";s:51:"Resources/Private/Templates/article/loadMapXml.html";s:4:"e0b9";s:53:"Resources/Private/Templates/article/loadMediaBox.html";s:4:"2c8d";s:51:"Resources/Private/Templates/article/loadTagBox.html";s:4:"01af";s:44:"Resources/Private/Templates/article/new.html";s:4:"0213";s:45:"Resources/Private/Templates/article/show.html";s:4:"f217";s:56:"Resources/Private/Templates/article/uploadMediafile.html";s:4:"318c";s:44:"Resources/Private/Templates/author/edit.html";s:4:"31dd";s:45:"Resources/Private/Templates/author/index.html";s:4:"4169";s:43:"Resources/Private/Templates/author/new.html";s:4:"7a4f";s:44:"Resources/Private/Templates/author/show.html";s:4:"de48";s:48:"Resources/Private/Templates/login/loginForm.html";s:4:"30c8";s:43:"Resources/Private/Templates/media/edit.html";s:4:"92c5";s:44:"Resources/Private/Templates/media/index.html";s:4:"3553";s:42:"Resources/Private/Templates/media/new.html";s:4:"f202";s:43:"Resources/Private/Templates/media/show.html";s:4:"55cf";s:47:"Resources/Private/Templates/mediafile/edit.html";s:4:"bb07";s:48:"Resources/Private/Templates/mediafile/index.html";s:4:"ab04";s:46:"Resources/Private/Templates/mediafile/new.html";s:4:"6153";s:47:"Resources/Private/Templates/mediafile/show.html";s:4:"7e45";s:43:"Resources/Private/Templates/place/edit.html";s:4:"3304";s:44:"Resources/Private/Templates/place/index.html";s:4:"64f6";s:55:"Resources/Private/Templates/place/loadChildOptions.html";s:4:"840c";s:60:"Resources/Private/Templates/place/loadPathToRootOptions.html";s:4:"17de";s:42:"Resources/Private/Templates/place/new.html";s:4:"da90";s:43:"Resources/Private/Templates/place/show.html";s:4:"423b";s:44:"Resources/Private/Templates/school/edit.html";s:4:"babe";s:45:"Resources/Private/Templates/school/index.html";s:4:"3d09";s:43:"Resources/Private/Templates/school/new.html";s:4:"fecf";s:44:"Resources/Private/Templates/school/show.html";s:4:"26c7";s:42:"Resources/Private/Templates/user/edit.html";s:4:"f7da";s:43:"Resources/Private/Templates/user/index.html";s:4:"23ae";s:41:"Resources/Private/Templates/user/new.html";s:4:"c67c";s:42:"Resources/Private/Templates/user/show.html";s:4:"4f95";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:54:"Resources/Public/Icons/tx_wpj_domain_model_article.gif";s:4:"905a";s:59:"Resources/Public/Icons/tx_wpj_domain_model_articletype.gif";s:4:"1103";s:53:"Resources/Public/Icons/tx_wpj_domain_model_author.gif";s:4:"905a";s:52:"Resources/Public/Icons/tx_wpj_domain_model_media.gif";s:4:"1103";s:56:"Resources/Public/Icons/tx_wpj_domain_model_mediafile.gif";s:4:"905a";s:52:"Resources/Public/Icons/tx_wpj_domain_model_place.gif";s:4:"905a";s:53:"Resources/Public/Icons/tx_wpj_domain_model_school.gif";s:4:"905a";s:58:"Resources/Public/Icons/tx_wpj_domain_model_schooltype.gif";s:4:"4e5b";s:50:"Resources/Public/Icons/tx_wpj_domain_model_tag.gif";s:4:"1103";s:56:"Resources/Public/Icons/tx_wpj_domain_model_taxonomy.gif";s:4:"4e5b";}',
);

?>