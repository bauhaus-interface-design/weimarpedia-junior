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
 * Controller for managing articles by admins
 * for listing and showing articles as user see articleController 
 * 
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_articleAdminController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Repository_articleRepository
	 */
	protected $articleRepository;

	/**
	 * @var Tx_Wpj_Domain_Repository_tagRepository
	 */
	protected $tagRepository;	
	
	
	/**
	 * @var Tx_Wpj_Domain_Model_author
	 */
	protected $author;
	
	
	/**
	 * Initializes the current action
	 * only allow admins with level >= 10 to use this controller
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->author = $authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	

	/**
	 * List all articles
	 */
	public function indexAction() {
		$articles = $this->articleRepository->findAll('', ''); // ($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL)
		$this->view->assign('articles', $articles);
		return $this->view->render();
	}
	
	
	/**
	 * List all articles with type knowledge 
	 */
	public function indexKnowledgeAction() {
		$articles = $this->articleRepository->findAll('', 'knowledge'); // ($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL)
		$template = 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Private/Templates/articleAdmin/index.html';		
		$this->view->setTemplatePathAndFilename($template);
    	$this->view->assign('articles', $articles);
		return $this->view->render();
	}

	/**
	 * List all articles with type exhibition 
	 */
	public function indexExhibitionAction() {
		$articles = $this->articleRepository->findAll('', 'exhibition'); // ($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL)
		$template = 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Private/Templates/articleAdmin/index.html';      
        $this->view->setTemplatePathAndFilename($template);
        $this->view->assign('articles', $articles);
		return $this->view->render();
	}	

	/**
	 * List last modified 30 articles
	 */
	public function indexLastModifiedAction() {
		$articles = $this->articleRepository->findAll('', '', "tstamp", "DESC", 30); // ($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL)
		$template = 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Private/Templates/articleAdmin/index.html';      
        $this->view->setTemplatePathAndFilename($template);
        $this->view->assign('articles', $articles);
		return $this->view->render();
	}

	/**
	 * List all unreviewed articles
	 */
	public function indexNotReviewedAction() {
		$articles = $this->articleRepository->findAll(0, ''); // ($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL)
		$template = 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Private/Templates/articleAdmin/index.html';      
        $this->view->setTemplatePathAndFilename($template);
        $this->view->assign('articles', $articles);
		return $this->view->render();
	}
	
	
	/**
	 * Deletes an existing article
	 *
	 * @param Tx_Wpj_Domain_Model_article $article The article to be deleted
	 */
	public function deleteAction(Tx_Wpj_Domain_Model_article $article) {
		$this->articleRepository->remove($article);
		$this->flashMessageContainer->add('Der Artikel wurde entfernt.');
		
		$this->redirect('index');
	}

	/**
	 * 
	 */
	public function backupWizardAction() {
		$versions = $this->articleRepository->findAllVersionsByArticles();
		$this->view->assign('versions', $versions);
	}

	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article $article The article
	 * @param int $voting 
  	 * @dontverifyrequesthash
	 */
	public function setVotingAction(Tx_Wpj_Domain_Model_article $article, $voting) {
		if ($this->adminLevelMin(5)){
			$article->setVoting($voting);
			$this->articleRepository->update($article);
			
			$this->throwStatus(200,"success","success");
			$this->flashMessageContainer->flush();
			exit();
			
		} else {
			$this->flashMessageContainer->add('Nix da!');
			$this->redirect('index');
		}
	}
	



	/**
	 * just for testing purposes...
	 *
	 */
	private function setIndexView(){
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		
		$templatePathAndFilename = t3lib_div::getFileAbsFilename( 'ArticleAdmin/Index.html');
		//var_dump($extbaseFrameworkConfiguration);die();
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
		//var_dump($templatePathAndFilename);die();
		
	}
	
}
?>