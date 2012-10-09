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
 * Controller to manage the map section with map, lists and article views
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_mapController extends Tx_Extbase_MVC_Controller_ActionController {
		
	/**
	 * @var Tx_Wpj_Domain_Repository_articleRepository
	 */
	protected $articleRepository;
		
	/**
	 * @var Tx_Wpj_Domain_Repository_placeRepository
	 */
	protected $placeRepository;
	
    /**
     * @var Tx_Wpj_Utility_ThumbProcessing
     */
    protected $thumbProcessor;
    
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
        $this->thumbProcessor = t3lib_div::makeInstance('Tx_Wpj_Utility_ThumbProcessing');
	}
	
	/**
	 * List action for this controller. Displays a map
	 */
	public function indexAction() {
		
	}
	
	/**
  	* Returns all places for a given map area as json 
    *  	
  	* @return string json
  	*/
	public function loadPlacesAction() {
		$sLat = floatVal( $this->request->getArgument('sLat') );
		$wLng = floatVal( $this->request->getArgument('wLng') );
		$nLat = floatVal( $this->request->getArgument('nLat') );
		$eLng = floatVal( $this->request->getArgument('eLng') );
		
		$response = array(
			'places' => $this->placeRepository->findWithinBoundsAsArray($sLat, $wLng, $nLat, $eLng),
			'persons' => array(),
			'objects' => array()
		);
		return json_encode($response); // don't mask slashes in closing htmltags
	}
	
	
	/**
  	* Returns all articles and ref-articles for a given place as json 
    * 
  	* @param Tx_Wpj_Domain_Model_place $place 	
  	* @param String $articletype 
  	* @return string json
  	*/
	public function placeArticlesAction(Tx_Wpj_Domain_Model_place $place, $articletype) {
		$refarticles = $this->articleRepository->getReferenceArticlesOfPlaceUid($place->getUid());
      
		$articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid(), $articletype);
		if ($articles->count() < 4) { // expand short lists by more results
			// load all articles
			$uids = collectChildrenUidsFast($place);
			$articles2 = $this->articleRepository->getArticlesOfPlaceUid($uids, $articletype);
			if ($articles->count() < 15) $articles = array_merge($articles->toArray(), $articles2->toArray());
		}
		
		$response = array(
			'type' => $articletype,
			'uid' => $place->getUid(),
			'name' => $place->getName(),
            'refarticles' => $this->article2json($refarticles),
			'articles' => $this->article2json($articles),
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* Returns floors for a place as json
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return string json
  	*/
	public function listPlaceOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		$refarticles = $this->articleRepository->getReferenceArticlesOfPlaceUid($place->getUid());
        foreach ($refarticles as $a){}
        
		$articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid());
		if ($articles->count() < 4) { // expand short lists by more results
			// load articles for child places
			$uids = collectChildrenUidsFast($place);
			$articles2 = $this->articleRepository->getArticlesOfPlaceUid($uids);
			if ($articles2->count() < 15) $articles = array_merge($articles->toArray(), $articles2->toArray());
		}
		
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'floors' => $this->placeRepository->getFloors($place),
            'refarticles' => $this->article2json($refarticles),
            'articles' => $this->article2json($articles),
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* Returns rooms for a place as json
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return string json
  	*/
	public function listFloorOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		$roomArray = array();
		$rooms = $this->placeRepository->findChildrenFast($place);
		foreach ($rooms as $room){
		    $articles = $room->getArticles();
            $articleNum = (gettype($articles) == "array") ? count($articles) : 0;
            $articlesHint = ($articleNum > 0) ? " (".$articleNum.")" : '';
            
			$roomArray[] = array(
				'uid' => $room->getUid(),
				'name' => $room->getName() . $articlesHint,
				'num_articles' => $articleNum
			);
		}
		
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'image' => $this->thumbProcessor->getThumb('uploads/wpj/floormaps/'.$place->getImage() , 880, NULL),
			'rooms' => $roomArray,
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* Returns articles for a place as json
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return string json
  	*/
	public function listRoomArticlesAction(Tx_Wpj_Domain_Model_place $place) {
		$refarticles = $this->articleRepository->getReferenceArticlesOfPlaceUid($place->getUid());
        $articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid());
			
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
            'refarticles' => $this->article2json($refarticles),
            'articles' => $this->article2json($articles),
		);
		return json_encode($response);
	}
	
	/**
  	* Returns article data as json
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return string json
  	*/
	public function showArticleAction(Tx_Wpj_Domain_Model_article $article) {
		$response = array(
			'title' => $article->getTitle(),
			'body' => $article->getBody()
		);
		return json_encode($response) ;
	}
	
	
	/**
    * load media for article by ajax
    *       
    * @param Tx_Wpj_Domain_Model_article $article The article to display
    * @dontvalidate $article
    */
    public function loadMediaAction(Tx_Wpj_Domain_Model_article $article) {
        $this->view->assign('article', $article);
    }
	
	/**
    * converts article objects to array
    * 
    */
	private function article2json($articles){
	    $articleArray = array();
        foreach ($articles as $article){
            $thumb = $this->thumbProcessor->getThumb($article->getThumbnailUrl(), NULL, 40);
            $articleArray[] = array(
                'uid' => $article->getUid(),
                'title' => $article->getTitle(),
                'thumbnail' => $thumb,
                'type' => $article->getArticletypeCSSClass(),
            );
        }
        return $articleArray;
	}
}
?>