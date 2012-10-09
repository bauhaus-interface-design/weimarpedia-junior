<?php

/***************************************************************
*  Copyright notice
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * list, show and edit articles for users
 * for managing articles as admin see articleAdminController 
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_articleController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Repository_articleRepository
	 */
	protected $articleRepository;

	/**
	 * @var Tx_Wpj_Domain_Repository_tagRepository
	 */
	protected $tagRepository;	
	
	/**
	 * @var Tx_Wpj_Domain_Repository_authorRepository
	 */
	protected $authorRepository;	
	
	
	/**
	 * @var Tx_Wpj_Domain_Model_author
	 */
	protected $author;
	
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	
	/**
  	* Adds a tag to an article by ajax
  	* 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param String $json 
  	* @dontverifyrequesthash
  	*/
	public function addTagAction(Tx_Wpj_Domain_Model_article $article, $json) {
		// we have different type of tags here:
		// 1. existing tags with type:tag and uid
		// 2. new tags with label (and taxonomy?)
		// 3. places, which have to be converted to tags unless there is an existing tag
		$tagRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_tagRepository');
		$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
		$tagobjects = json_decode($json);
		foreach($tagobjects as $tagobject){
			$taxonomy = (strtolower($tagobject->taxonomy) == 'refplace') ? 2 : 1;
			
			if ($tagobject->type == 'tag' && $tagobject->uid > 0){ // existing tag
				$tag = $tagRepository->findByUid($tagobject->uid);
			} else if ($tagobject->type == 'place') {
				$tag = $tagRepository->findOrCreateByPlaceAndTaxonomy($tagobject->uid, $taxonomy);
			} else {
				// is there a tag with this label and taxonomy?
				$name = trim($tagobject->label);
				$tag = $tagRepository->findOneByLabelAndTaxonomy($name, $taxonomy);
				if (!$tag) {
					// create tag
					$tag = new Tx_Wpj_Domain_Model_tag();
					$tag->setName( $name );
					$taxonomyId = (int) $tagobject->taxonomy;
					if ($taxonomyId > 0) {
						$taxonomyRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_taxonomyRepository');
						$taxonomy = $taxonomyRepository->findByUid($taxonomyId);
						$tag->setTaxonomy($taxonomy);
					}
				}
			}
			$article->addTag($tag);
		}
		
		return "success";
	}

	
	/**
  	* Removes a tag from an article by ajax
  	* 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param Tx_Wpj_Domain_Model_tag $tag The article to display
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function removeTagAction(Tx_Wpj_Domain_Model_article $article, Tx_Wpj_Domain_Model_tag $tag) {
		if ($this->editingAllowed($article)){
			// remove tag from article
			$article->removeTag($tag);
		}	
		return "success";
	}

	/**
  	* suggests tags for $term as json
    * 
    * @return string json
  	*/
	public function suggestTagAction() {
		$term = $_GET['term']; // TODO: use quote-function provided by a future version of exbase
		$tagRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_tagRepository');
		$tags = $tagRepository->suggestAsArray("%$term");	
		return json_encode($tags); // don't mask slashes in closing htmltags
	}

	/**
  	* suggests place tags for $term as json
    * 
    * @return string json
  	*/
	public function suggestTagPlaceAction() {
		$term = $_GET['term']; // TODO: use quote-function provided by a future version of exbase
		$accuracy = (int) $_GET['accuracy']; // allow neg. numbers e.g. -7 means <=7
		$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
		$places = $placeRepository->suggestAsArray($term, $accuracy);
		return json_encode($places); // don't mask slashes in closing htmltags
	}
	
	/**
	 * suggests childs for a place as json
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place 
     * @return string json
	 */
	public function loadPlaceChildrenAction() {
		$parentUid = (int) $_GET['root'];
		$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
		$parentPlace = $placeRepository->findByUid( $parentUid );
		$response = array();
		foreach ($parentPlace->getChildren() as $place){	
			$r = array();
			$r['uid'] = $place->getUid();
		    $r['value'] = $place->getName();
		    $r['label'] = $place->getName();
		    $r['image'] = $place->getImage();
			$response[] = $r;
		}
		return json_encode($response);
	}
	
	/**
  	* loads the form in iframe
    * 
  	*/
	public function placeSelectFormAction() {
		
	}
	
	/**
  	* loads the form in iframe
    * 
  	*/
	public function refPlaceSelectFormAction() {
		
	}
	
	
	/**
  	* Loads the tag box content by ajax
  	*   	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param string $scope 
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadTagBoxAction(Tx_Wpj_Domain_Model_article $article, $scope = NULL) {
		if ($scope == 'refplace'){
			$tags = $article->getRefPlaceTag();
		} else if ($scope == 'place'){
			$tags = $article->getPlaceTags();
		} else {
			$tags = $article->getNonPlaceTags();
		}  			
		$this->view->assign('tags', $tags);
	}

/** Mediamanagement **/	

	/**
  	* load mediabox by ajax
  	*   	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadMediaBoxAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}
	
	/**
  	* add media
  	* 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
    * @param object $search
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function addMediaAction(Tx_Wpj_Domain_Model_article $article, $search=null) {
		if ($this->editingAllowed($article)){
			$this->addEditingHeaders();
			$this->view->assign('article', $article);
            $this->view->assign('search', $search);
			$mediafileRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_mediafileRepository');
			if ($search == null) $this->view->assign('mediafiles', $mediafileRepository->findAll());
            else $this->view->assign('mediafiles', $mediafileRepository->search($search['search']));
		
		} else die("Sie haben keine ausreichenden Rechte.");
	}
	
	/**
  	* add mediafile
  	* 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param Tx_Wpj_Domain_Model_mediafile
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function addMediafileAction(Tx_Wpj_Domain_Model_article $article, Tx_Wpj_Domain_Model_mediafile $mediafile) {
		if ($this->editingAllowed($article)){
			$this->view->assign('article', $article);
			
			// create Media and assign it
			$newMedia = new Tx_Wpj_Domain_Model_media();
			$newMedia->setMediafile($mediafile);
			$article->addMedia($newMedia);
				
			$this->flashMessageContainer->add('Das Medienelement wurde hinzugefuegt.');
			
		} else die("Sie haben keine ausreichenden Rechte.");	
		$this->redirect('addMedia', NULL, NULL, array('article' => $article) );	
	}
	
	/**
  	* upload a file, create a new mediafile, create a new file
  	* 
  	* @dontverifyrequesthash
  	*/
	public function uploadMediafileAction() {
		$article = $this->articleRepository->findByUid( $this->request->getArgument('article_id') ); // workaround
		if ($this->editingAllowed($article)){
			$this->view->assign('article', $article);
		
			if ($_FILES['tx_wpj_pi1']) { //  && $_FILES['tx_wpj_pi1']['error']==0
				// create file
				$basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions');
				$basename = $basicFileFunctions->cleanFileName( $_FILES['tx_wpj_pi1']['name']['article']['mediafile'] );
				$fileName = $basicFileFunctions->getUniqueName($basename, t3lib_div::getFileAbsFileName('uploads/wpj/mediafiles'));
		 
				$result = t3lib_div::upload_copy_move( $_FILES['tx_wpj_pi1']['tmp_name']['article']['mediafile'], $fileName );
		 		
				// create Mediafile
				$newMediafile = new Tx_Wpj_Domain_Model_mediafile($fileName, "caption");
				$newMediafile->setContentType( $_FILES['tx_wpj_pi1']['type']['article']['mediafile'] );
				$this->mediafileRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_mediafileRepository');
				$this->mediafileRepository->add($newMediafile);
				
				// create Media and assign it
				$newMedia = new Tx_Wpj_Domain_Model_media();
				$newMedia->setMediafile($newMediafile);
				$article->addMedia($newMedia);
				
				$this->flashMessageContainer->add('Die Datei wurde hochgeladen und dem Artikel zugewiesen.');
				$uploadMessage = 'Die Datei wurde hochgeladen und dem Artikel zugewiesen. <a href="javascript:$.fancybox.close();">Fenster schliessen</a>';
			}
			$this->view->assign('uploadMessage', $uploadMessage);
			
			
			$closeWindow = ($this->request->getArgument('closeWindow') == "true");
			if ($closeWindow) $this->redirect('closeFancyBox');
			else $this->redirect('addMedia', NULL, NULL, array('article' => $article) );
			
		}
	}

	
	/**
  	*  redirect is needed, otherwise upload is aborted
  	*/
	public function closeFancyBoxAction(){
		$additionalHeaderData = '
			<script type="text/javascript">
				parent.$.fancybox.close();
			</script>';
        echo $additionalHeaderData;
        exit();
	}
	
	
	/**
  	* remove media from article
    * 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param Tx_Wpj_Domain_Model_media $media
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function removeMediaAction(Tx_Wpj_Domain_Model_article $article, Tx_Wpj_Domain_Model_media $media) {
		if ($this->editingAllowed($article)){
			// remove media from article
			$article->removeMedia($media);
			$this->flashMessageContainer->add('Die Datei wurde entfernt.');
		}	
		$this->redirect('addMedia', NULL, NULL, array('article' => $article) );
	}
	
	/**
  	* show medias
    *   	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function showMediasAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}	
	
	
	/**
  	* show map
    *   	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadMapBoxAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}	
	
	/**
  	* load map data  	
    * 
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadMapXmlAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}

	
	/**
  	* load authors   
    * 	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadAuthorsBoxAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
		$this->view->assign('publicAuthors', $this->authorRepository->findPublicAuthorsOf($article));
		$this->view->assign('hiddenAuthors', $this->authorRepository->findHiddenAuthorsOf($article));
	}

	
	/**
  	* load versions
    *   	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function loadVersionsBoxAction(Tx_Wpj_Domain_Model_article $article) {
		$this->view->assign('article', $article);
		$versions = $this->articleRepository->findAllVersions($article);
		$this->view->assign('versions', $versions);
	}
	
	
	/**
  	* compare versions  
    * 	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
  	* @param string $version The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function compareVersionsAction(Tx_Wpj_Domain_Model_article $article, $version_id) {
		$this->view->assign('article', $article);
		$version = $this->articleRepository->findVersion($version_id);
		$this->view->assign('version_id', $version_id);
		$this->view->assign('version', $version);
		
		$this->view->assign('title_diff', $article->getVersionDiffTitle($version));
        $this->view->assign('body_diff', $article->getVersionDiffBody($version));
	}	
	
	/**
  	* remove given author 
    *  	
  	* @param Tx_Wpj_Domain_Model_article $article The article to display
	* @param Tx_Wpj_Domain_Model_author $author
  	* @return void
  	* @dontvalidate $article
  	*/
	public function removeAuthorAction(Tx_Wpj_Domain_Model_article $article, Tx_Wpj_Domain_Model_author $author) {
		if ($this->adminLevelMin(9)) {
			$article->removeAuthor($author);
			$this->flashMessageContainer->add('Der Autor wurde entfernt.');
			
			$this->redirect('show', 'article', 'wpj', array('article' => $article));
		}
		return false;
	}
		
		
		
		
	/**
  	* suggests tags for $term as json
    * 
    * @return string json
  	*/
	public function suggestArticleAction() {
		$term = $_GET['term']; // TODO: use quote-function provided by a future version of exbase
		$demand = new Tx_Wpj_Domain_Model_Demand();
		$demand->setSearchterm($term);
		$demand->setScope("");
		$articles = $this->articleRepository->searchLike($demand);
		
		// collect in array (for json conversion) and make unique
		$uids = array();
		$response = array();
		$maxResults = 30;	
		foreach ($articles as $article){	
			$r = array();
			$r['id'] = $article->getUid();
		    $r['name'] = $article->getTitle();
		    $r['path'] = "Artikel: ".$article->getTitle(); 
			$r['url'] = 'http://weimarpedia.de/index.php?tx_wpj_pi1[action]=show&tx_wpj_pi1[controller]=article&tx_wpj_pi1[article]='.$article->getUid();
			$r['type'] = "website";
			$r['weight'] = .5;
			
		    if (!in_array( $article->getUid() , $uids)){ // make unique
				$response[] = $r;
		    	$uids[] = $article->getUid();
			}
		    if (count($response) > $maxResults) break;
		}
		
		return json_encode($response); 
	}
		
	/**
	 * Displays all articles with type knowledge
     * for anonym users show only reviewed articles  
     * 
	 */
	public function indexAction() {
		if ( !$GLOBALS['TSFE']->loginUser ) {
			// everyone: only reviewed articles
			$articles = $this->articleRepository->findAll(); 
		} else {
			// logged in: all articles
			$articles = $this->articleRepository->findAll("");  
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('wrapperCssClass', ' class="knowledge"');
        
        $this->setPageTitel("Lexikon");
	}

	/**
	 * Displays all articles with type exhibition
     * for anonym users show only reviewed articles 
	 * 
	 */
	public function exhibitionAction() {
		$selection = ($this->request->hasArgument('selection'))? intval($this->request->getArgument('selection')) : 0;
		
		$reviewed = ( !$GLOBALS['TSFE']->loginUser ) ? 1 : "";
		if ($selection == 1){
			// top articles within 12 months
			$articles = $this->articleRepository->findTopYear();
		} else if ($selection == 2){
			// alltime favorits
			$articles = $this->articleRepository->findTopAlltime();
		} else {
			// newest articles
			$articles = $this->articleRepository->findAll($reviewed, "gallery");
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('wrapperCssClass', ' class="exhibition"');
        
        $this->setPageTitel("Galerie");
	}
		
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * @param Tx_Wpj_Domain_Model_tag $tag
	 */
	public function indexByTagAction(Tx_Wpj_Domain_Model_tag $tag) {
		$reviewed = ( !$GLOBALS['TSFE']->loginUser ) ? 1 : "";
		$articles = $this->articleRepository->findByTag($tag, $reviewed);
		$this->view->assign('articles', $articles);
		$this->view->assign('tag', $tag);
		$this->view->assign('scope', "Lexikon");
	}

	/**
	 * 
	 */
	public function indexByAuthorAction(Tx_Wpj_Domain_Model_author $author) {
		$reviewed = ( !$GLOBALS['TSFE']->loginUser ) ? 1 : "";
		$articles = $this->articleRepository->findByAuthor($author, $reviewed, '');
		$this->view->assign('articles', $articles);
		$this->view->assign('author', $author);
	}

	/**
	 * @param Tx_Wpj_Domain_Model_school 
	 */
	public function indexBySchoolAction(Tx_Wpj_Domain_Model_school $school) {
		$this->view->assign('school', $school);
		$authors = $this->authorRepository->findBySchool($school);
		$this->view->assign('authors', $authors);
		$reviewed = ( !$GLOBALS['TSFE']->loginUser ) ? 1 : "";
		$articles = $this->articleRepository->findByAuthors($authors, $reviewed, '');
		$this->view->assign('articles', $articles);
	}
		

	/**
	 * Displays a form to edit an existing article
	 *
	 * @param Tx_Wpj_Domain_Model_article $article The article to display
	 * @dontvalidate $article
	 */
	public function showAction(Tx_Wpj_Domain_Model_article $article=NULL) {
		
		if ($article == NULL) {
			// fresh created article
			$article = new Tx_Wpj_Domain_Model_article();
			$article->addAuthor($this->author);
			$article->setReviewed(false);
			$this->articleRepository->add($article);
			$pM = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
    		$pM->persistAll();
    	
			// start edit mode immediately
			$additionalHeaderData_create = '
	            <script type="text/javascript">
	            <!--
	                $(document).ready(function(){
					  window.setTimeout("Wpj.startEditMode()", 4000);
					});
	        	// -->
	        	</script>';
			
		}
		
		$this->view->assign('article', $article);
		// user rights
		$this->view->assign('editingAllowed', $this->editingAllowed($article));
		
		// collecting additional data for editing/managing metainfos 
		// only for editors
		if ($this->adminLevelMin(1)) {
			// taxonomies
			if ($article->getArticletype() > 0){
				$taxonomyRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_taxonomyRepository');
				$this->view->assign('taxonomies', $taxonomyRepository->findByArticletype( $article->getArticletype() ));	
			}
			
			// articletypes
			$articleTypeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articletypeRepository');
			$this->view->assign('articletypes', $articleTypeRepository->findAllPublic());	
			
			// text editing
			if ($this->editingAllowed($article)) {
	        	$this->addAlohaJS();
	        	$this->addEditingHeaders();
	        }
		}
		
        //$this->addGMapJS();
        	
        if ($additionalHeaderData_create) $this->response->addAdditionalHeaderData($additionalHeaderData_create);
        
        $this->setPageTitel($article->getTitle());

	}

	/**
	 * Updates an existing article and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_article $article The article to display
  	 * @dontverifyrequesthash
	 */
	public function updateAction(Tx_Wpj_Domain_Model_article $article) {
			
		// TODO: if an reviewed article is changed by a editor <10, set reviewed to false (and send mail?)	
			
		if ($this->editingAllowed($article)){
			if ($article->getReviewed() == -1) {
				// fresh created articles are marked by reviewed = -1
				$article->setReviewed(0);
				$this->flashMessageContainer->add('Der Artikel wurde angelegt.');
			}else {
				$this->articleRepository->backup($article, $this->request->hasArgument('autosave'));
				$this->flashMessageContainer->flush();
				// TODO: this message appears two times (because of the backup-task !?)
				$this->flashMessageContainer->add('Der Artikel wurde aktualisiert.');
			}
			
			$article->addAuthor($this->author);
			
			$article->setMediaContent( $this->request->getArgument('mediaContent') ); // set media descriptions from array
			$this->articleRepository->update($article);
		}else{
			$this->flashMessageContainer->add('Sie d&uuml;rfen keine Artikel bearbeiten.');
		}
		if ($this->request->hasArgument('ajax')) {
			$this->flashMessageContainer->flush();
			$this->throwStatus(200,"success","success");
			exit();
		}else{
			$this->redirect('index_loggedIn', 'dashboard'); // TODO: redirect admin?
		}
	}
	
	
	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article $article The article
	 * @param int $reviewed 
  	 * @dontverifyrequesthash
	 */
	public function setReviewAction(Tx_Wpj_Domain_Model_article $article, $reviewed) {
		if ($this->adminLevelMin(5)){
			$article->setReviewed($reviewed);
			$this->articleRepository->update($article);
			if ($reviewed==1) {
				$this->flashMessageContainer->add('Der Artikel wurde freigegeben.');
			} else {
				$this->flashMessageContainer->add('Die Freigabe wurde zur&uuml;ckgezogen.');
			}
		} else $this->flashMessageContainer->add('Nix da!');
		$this->redirect('index');
	}

	
	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_Demand $demand 
  	 * @dontverifyrequesthash
	 */
	public function searchAction(Tx_Wpj_Domain_Model_Demand $demand = NULL) {
		$articles = $this->articleRepository->search($demand); // TODO: check userrights / manipulations
		$this->view->assign('articles', $articles);
		$this->view->assign('demand', $demand);
        
        $this->setPageTitel($demand->getSearchterm());
	}
	
	
	private function addGMapJS() {
		$additionalHeaderData = '
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
			<script type="text/javascript" src="typo3conf/ext/wpj/Resources/Public/js/maps.js"></script>
';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
	}
	
	private function addAlohaJS() {
		$additionalFooterData = '
		
			<link rel="stylesheet" href="typo3conf/ext/wpj/Resources/Public/js/aloha/css/aloha.css" id="aloha-style-include" type="text/css">
			<script src="typo3conf/ext/wpj/Resources/Public/js/aloha/aloha_config.js"></script>
	<!--  common/highlighteditables,
	                            common/block,
	                            common/undo,
	                            common/contenthandler,
	                            common/paste,
	                            common/table,common/commands,
	                            extra/flag-icons,
	                            common/abbr,
	                            extra/wai-lang,
	                            extra/browser,
	                            extra/linkbrowser,
	                            extra/attributes,extra/googletranslate,extra/metaview,extra/wai-lang,extra/headerids,extra/cite  
	-->
	<script src="typo3conf/ext/wpj/Resources/Public/js/aloha/lib/aloha.js"
	        data-aloha-plugins="common/format,
	        common/highlighteditables,
	        common/list,
	        common/link,
	        common/undo,
	        common/paste"></script>
';
        $this->view->assign('additionalFooterData', $additionalFooterData);
	}	

	private function addEditingHeaders() {
		$additionalHeaderData = '
			<link rel="stylesheet" type="text/css" href="typo3conf/ext/wpj/Resources/Public/stylesheets/custom-theme/jquery-ui-1.8.9.custom.css" media="screen,projection,handheld" />
';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
	}
	
	private function editingAllowed($article){
		if ( !$GLOBALS['TSFE']->loginUser ) return false;
		return ( (int)$GLOBALS["TSFE"]->fe_user->user['tx_wpj_admin'] >= 0);
	}
	private function creatingAllowed(){
		if ( !$GLOBALS['TSFE']->loginUser ) return false;
		return ( (int)$GLOBALS["TSFE"]->fe_user->user['tx_wpj_admin'] >= 0);
	}


    private function setPageTitel($title){
        $GLOBALS['TSFE']->config['config']['noPageTitle'] = 2;
        $GLOBALS['TSFE']->additionalHeaderData['titletag'] = "<title>$title - Weimarpedia</title>";
    }
    
    
	
}