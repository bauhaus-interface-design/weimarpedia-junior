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
 * Controller to manage search requests
 * see the Tx_Wpj_Domain_Model_Demand object for the structure of the request
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_searchController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Repository_articleRepository
	 */
	protected $articleRepository;
	
	/**
	 * @var Tx_Wpj_Domain_Repository_authorRepository
	 */
	protected $authorRepository;

	/**
	 * @var Tx_Wpj_Domain_Repository_schoolRepository
	 */
	protected $schoolRepository;
	
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
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->schoolRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_schoolRepository');
		$this->tagRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_tagRepository');
		$this->author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	
	/**
	 * List action for this controller
	 * 
	 * @param Tx_Wpj_Domain_Model_Demand $demand
  	 * @dontvalidate $demand
  	 * @dontverifyrequesthash
	 */
	public function indexAction(Tx_Wpj_Domain_Model_Demand $demand=NULL) {
		if ($demand) {
			
			// check demand: > 2 chars?
			$term = $demand->getSearchterm();
			if (strlen($term) < 2) {
				$this->flashMessageContainer->add('Bitte gib ein längeres Suchwort ein.');
				$this->redirect('index', 'article');
			} 
			$this->view->assign('demand', $demand);
			
			switch ($demand->getScope()) {
				case 'knowledge':
					list($articles, $authorArticles, $schoolArticles) = $this->searchArticles($demand);
					break;
				case 'gallery':
					list($articles, $authorArticles, $schoolArticles) = $this->searchArticles($demand);
					break;
				case 'people': // articletype = 2
					list($articles, $authorArticles, $schoolArticles) = $this->searchArticles($demand);
					break;
				case 'objects':// articletype = 3
					list($articles, $authorArticles, $schoolArticles) = $this->searchArticles($demand);
					break;
				case 'authors':
					$authors = $this->authorRepository->search($term);
					$this->view->assign('authors', $authors);
					$schools = $this->schoolRepository->search($term);
					$this->view->assign('schools', $schools);
					break;
				default:
					list($articles, $authorArticles, $schoolArticles) = $this->searchArticles($demand);
			}
			
			$this->view->assign('articles', $articles);
			$this->view->assign('authorArticles', $authorArticles);
			$this->view->assign('schoolArticles', $schoolArticles);
			
			// further links
			if ($demand->getScope() != 'authors'){
				// tags
				if (strlen($term) > 3) $meta_tags = $this->tagRepository->search($demand->getSearchterm());
				$this->view->assign('meta_tags', $meta_tags);
				
				// authors
				if (strlen($term) > 3) $meta_authors = $this->authorRepository->search($demand->getSearchterm());
				$this->view->assign('meta_authors', $meta_authors);
				
				// schools
				$meta_schools = $this->schoolRepository->search($term);
				$this->view->assign('meta_schools', $meta_schools);
			}
			
			$this->view->assign('wrapperCssClass', ' class="search"');
			
		} else $this->redirect('index', 'article');
	}

    /**
     * Returns suggestions from google for $query
     * 
     * @param string $query
     */
	protected function getSuggestions($query){
		$lang = 'de';
		$url = 'http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=' . $lang . '&q=' . urlencode($query);
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.0; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");
		$data = curl_exec($ch);
		curl_close($ch);
		$suggestions = json_decode($data, true);
		
		if ($suggestions) {
		    echo 'suggestions: ';
		    print_r($suggestions);
		} else {
		    echo 'no suggestion';
		}
		
	}
	
    /**
     * Searchs for articles, authors and schools for a given demand
     * 
     * @param Tx_Wpj_Domain_Model_Demand $demand
     */
	private function searchArticles($demand){
		$term = $demand->getSearchterm();
		
		// 1. exact match: redirect
		if (strlen($term) > 3) {
			$article = $this->articleRepository->findOneByTitle($term);
			if ($article){
				// redirect
				$this->redirect('show', 'article', NULL, array(article => $article->getUid()));
			}
		}
		
		// 2. no results: fuzzy search
		$articles = $this->articleRepository->search($demand);
		// bug in typo3 4.5.4 and 4.6.0: because of lazy loading, we need to fake access to the objects for correct count
		foreach($articles as $article){}
		
		if ($articles->count() < 5){
			// 3. no results: authors,schools and tags
			$authorArticles = $this->articleRepository->findByAuthorSearch($term,'','');
			$schools = $this->schoolRepository->search($term);
			if ($schools->count() > 0) {
				$schoolArticles = $this->articleRepository->findBySchools($schools);
			}
			
			// 4. if almost nothing is found until here search with like
			$schoolArticleEntries = (isset($schoolArticles)) ? $schoolArticles->count() : 0; // $schoolArticles is only set if schools found
			if ( $authorArticles->count() < 5 && $schoolArticleEntries == 0 && strlen($term) > 3 ){
				$articles2 = $this->articleRepository->searchLike($demand);
				$articles = array_unique(array_merge($articles->toArray(), $articles2->toArray()));
			}
		}
		
		return array($articles, $authorArticles, $schoolArticles);
	}
}
?>