<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 
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
 * Controller for the article object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_WpjV1_Controller_articleController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {
	
	/**
	 * @var Tx_WpjV1_Domain_Repository_articleRepository
	 */
	protected $articleRepository;

	/**
	 * @var Tx_WpjV1_Domain_Repository_tagRepository
	 */
	protected $tagRepository;	
	
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserRepository
	 */
	protected $frontendUserRepository;
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserGroup
	 */
	protected $frontendUserGroupsModel;
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserGroup
	 */
	protected $frontendUserGroupsRepository;
	
	protected $ALLOW_SAVING = false;
	
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_WpjV1_Domain_Repository_articleRepository');
		$this->conceptRepository = t3lib_div::makeInstance('Tx_WpjV1_Domain_Repository_conceptRepository');
		$this->mediaRepository = t3lib_div::makeInstance('Tx_WpjV1_Domain_Repository_mediaRepository');
	}
	
	/**
  	* 
  	* @param Tx_WpjV1_Domain_Model_article $article The article to display
  	* @param Tx_WpjV1_Domain_Model_tag $tag The article to display
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function addTagAction(Tx_WpjV1_Domain_Model_article $article, Tx_WpjV1_Domain_Model_tag $tag) {
		if ($ALLOW_SAVING){
			// create new tag
			$this->tagRepository = t3lib_div::makeInstance('Tx_WpjV1_Domain_Repository_tagRepository');
			$this->tagRepository->add($tag);
			// assign tag to article
			$article->addTag($tag);
		}
		//$this->view->assign('article', $article);
		return "success";
	}

	
	/**
  	* 
  	* @param Tx_WpjV1_Domain_Model_article $article The article to display
  	* @param Tx_WpjV1_Domain_Model_tag $tag The article to display
  	* @dontvalidate $article
  	* @dontverifyrequesthash
  	*/
	public function removeTagAction(Tx_WpjV1_Domain_Model_article $article, Tx_WpjV1_Domain_Model_tag $tag) {
		if ($ALLOW_SAVING){
			// remove tag from article
			$article->removeTag($tag);
			
			// TODO: remove tag from repository if not needed anymore
		}	
		//$this->view->assign('article', $article);
		return "success";
	}
	
	
	/**
  	*   	
  	* @param Tx_WpjV1_Domain_Model_article $article The article to display
  	* @return void
  	* @dontvalidate $article
  	*/
	public function showTagsAction(Tx_WpjV1_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}	
	
	/**
	 * List action for this controller. Displays all articles.
	 */
	public function indexAction() {
		$articles = $this->articleRepository->findAll();
		$this->view->assign('articles', $articles);
		
//		$ajaxUrl = $this->uriBuilder->uriFor(NULL, 'ajax', array(), NULL, NULL, NULL, 1249058991);
//		$this->view->assign('ajaxUrl', $ajaxUrl);
//		
//		$GLOBALS['TSFE']->getPageRenderer()->addExtOnReadyCode(
//			'Ext.Msg.alert("My Title", "Hello World!");'
//		);
	}

	/**
	 * Action that displays a single article
	 *
	 * @param Tx_WpjV1_Domain_Model_article $article The article to display
	 */
	public function showAction(Tx_WpjV1_Domain_Model_article $article) {
		$this->view->assign('article', $article);
	}

	/**
	 * Displays a form for creating a new article
	 *
	 * @param Tx_WpjV1_Domain_Model_article $newarticle A fresh article object taken as a basis for the rendering
	 * @dontvalidate $newarticle
	 */
	public function newAction(Tx_WpjV1_Domain_Model_article $newarticle = NULL) {
		$this->view->assign('newarticle', $newarticle);
		$this->flashMessageContainer->add('In dieser Ansichtsversion können Sie keine Artikel erstellen.');
	}

	/**
	 * Creates a new article and forwards to the index action.
	 *
	 * @param Tx_WpjV1_Domain_Model_article $newarticle A fresh article object which has not yet been added to the repository
	 */
	public function createAction(Tx_WpjV1_Domain_Model_article $newarticle) {
		if ($ALLOW_SAVING){
			$this->articleRepository->add($newarticle);
			$this->flashMessageContainer->add('Your new article was created.');
		}else {
			$this->flashMessageContainer->add('In dieser Ansichtsversion können Sie keine Artikel erstellen.');
		}
		$this->redirect('index');
	}

	/**
	 * Displays a form to edit an existing article
	 *
	 * @param Tx_WpjV1_Domain_Model_article $article The article to display
	 * @dontvalidate $article
	 */
	public function editAction(Tx_WpjV1_Domain_Model_article $article) {
		$this->view->assign('article', $article);
		$this->uriBuilder->setTargetPageType(10);
		
		// uriFor($actionName = NULL, $controllerArguments = array(), $controllerName = NULL, $extensionName = NULL, $pluginName = NULL) {
		$ajaxUrl = $this->uriBuilder->uriFor('addTag', array( "article" => $article->getUid(), "tag" => ''), 'article');
		$updateUrl = $this->uriBuilder->uriFor('showTags', array( "article" => $article->getUid()), 'article');
		$this->view->assign('ajaxUrl', $ajaxUrl);
		$this->view->assign('updateUrl', $updateUrl);
		
		$this->view->assign('concepts', $this->conceptRepository->findAll());
		$this->view->assign('medias', $this->mediaRepository->findAll());
		
//		$media1 = $this->mediaRepository->findByUid(1);
//		$article->addMedia($media1);
//		$this->articleRepository->update($article);
		
	}

	/**
	 * Updates an existing article and forwards to the index action afterwards.
	 *
	 * @param Tx_WpjV1_Domain_Model_article $article The article to display
  	 * @dontverifyrequesthash
	 */
	public function updateAction(Tx_WpjV1_Domain_Model_article $article) {
		if ($ALLOW_SAVING){
			$this->articleRepository->update($article);
			$this->flashMessageContainer->add('Your article was updated.');
		}else{
			$this->flashMessageContainer->add('In dieser Ansichtsversion können Sie keine Artikel bearbeiten.');
		}
		$this->redirect('index');
	}

	/**
	 * Deletes an existing article
	 *
	 * @param Tx_WpjV1_Domain_Model_article $article The article to be deleted
	 */
	public function deleteAction(Tx_WpjV1_Domain_Model_article $article) {
		if ($ALLOW_SAVING){
			$this->articleRepository->remove($article);
			$this->flashMessageContainer->add('Your article was removed.');
		}else{
			$this->flashMessageContainer->add('In dieser Ansichtsversion können Sie keine Artikel l&ouml;schen.');
		}
			
		$this->redirect('index');
	}
	

	
}
?>