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
 * Controller for the dashboard
 * this page is shown by requesting weimarpedia.de
 * if the user is logged in, show only own articles
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_dashboardController extends Tx_Wpj_Controller_protectedController {
	

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
     * Find author if logged in 
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	
	/**
  	* Index action
    * if user is logged in redirect to index_loggedIn
    * 
  	*/
	public function indexAction() {
		if ( $GLOBALS['TSFE']->loginUser ) $this->forward('index_loggedIn'); 
		// select reviewed articles
		$articles = $this->articleRepository->findAll(1, '', "tstamp", "DESC", 12); 
		$this->view->assign('articles', $articles);
		$article = $articles[rand(0,10)];
		$this->view->assign('featuredArticle', $article);
		$this->view->assign('wrapperCssClass', ' class="start"');
	}
	
	/**
  	* Index for logged in users  
    * list includes not reviewed articles 
  	*/
	public function index_loggedInAction() {
		if ( !$GLOBALS['TSFE']->loginUser ) $this->forward('index'); 
		// logged in: all articles 
		$author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
		$articles = $this->articleRepository->findByAuthor($author, ""); 
		$this->view->assign('articles', $articles);
		$this->view->assign('wrapperCssClass', ' class="start"');
	}
}
?>