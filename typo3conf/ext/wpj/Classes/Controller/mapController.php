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
 * Controller manage map-views
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
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
	}
	
	/**
	 * List action for this controller. Displays a map
	 */
	public function indexAction() {
		
		
	}
	
	/**
  	*   	
  	* @return void
  	*/
	public function searchAction() {
		
	}
	
	/**
  	*   	
  	* @return void
  	*/
	public function suggestAction() {
		
	}
	
	
	/**
  	*   	
  	* @return void
  	*/
	public function loadPlacesAction() {
		$layerBuildings = $this->request->getArgument('layerBuildings');
		$layerObjects = $this->request->getArgument('layerObjects');
		$layerPersons = $this->request->getArgument('layerPersons');
		
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
  	* TODO: allow knowledge / exhibition as type  
  	* @param Tx_Wpj_Domain_Model_place $place 	
  	* @param String $articletype 
  	* @return void
  	*/
	public function placeArticlesAction(Tx_Wpj_Domain_Model_place $place, $articletype) {
		//if (($articletype != 'knowledge') && ($articletype != 'exhibition')) {
			//$articletype = 'knowledge';
		//} 
		$articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid(), $articletype);
		if ($articles->count() < 4) { // expand short lists by more results
			// load all articles
			$uids = collectChildrenUidsFast($place);
			$articles2 = $this->articleRepository->getArticlesOfPlaceUid($uids, $articletype);
			if ($articles->count() < 15) $articles = array_merge($articles->toArray(), $articles2->toArray());
		}
		
		$articleArray = array();
		foreach ($articles as $article){
			$articleArray[] = array(
				'uid' => $article->getUid(),
				'title' => $article->getTitle(),
				'thumbnail' => $article->getThumbnailUrl()
			);
		}
		
		$response = array(
			'type' => $articletype,
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'articles' => $articleArray,
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* 
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return void
  	*/
	public function listPlaceOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		
		$articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid());
		if ($articles->count() < 4) { // expand short lists by more results
			// load all articles
			$uids = collectChildrenUidsFast($place);
			$articles2 = $this->articleRepository->getArticlesOfPlaceUid($uids);
			if ($articles->count() < 15) $articles = array_merge($articles->toArray(), $articles2->toArray());
		}
		
		$articleArray = array();
		foreach ($articles as $article){
			$articleArray[] = array(
				'uid' => $article->getUid(),
				'title' => $article->getTitle(),
				'thumbnail' => $article->getThumbnailUrl()
			);
		}
		
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'floors' => $this->placeRepository->getFloors($place),
			'articles' => $articleArray,
			//'test' => $children
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* 
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return void
  	*/
	public function listFloorOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		$roomArray = array();
		$rooms = $this->placeRepository->findChildrenFast($place);
		foreach ($rooms as $room){
			$roomArray[] = array(
				'uid' => $room->getUid(),
				'name' => $room->getName(),
			);
		}
		
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'image' => "http://".t3lib_div::getThisUrl().'uploads/wpj/floormaps/'.$place->getImage(), // floormap
			'rooms' => $roomArray,
			'articles' => array()
		);
		
		return json_encode($response);
	}
	
	
	/**
  	* 
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return void
  	*/
	public function listRoomArticlesAction(Tx_Wpj_Domain_Model_place $place) {
		$articles = $this->articleRepository->getArticlesOfPlaceUid($place->getUid());
		$articleArray = array();
		foreach ($articles as $article){
			$articleArray[] = array(
				'uid' => $article->getUid(),
				'title' => $article->getTitle(),
				'thumbnail' => $article->getThumbnailUrl()
			);
		}	
			
		$response = array(
			'uid' => $place->getUid(),
			'name' => $place->getName(),
			'articles' => $articleArray
		);
		
		return json_encode($response);
	}
	
	/**
  	* 
  	*   	
  	* @param Tx_Wpj_Domain_Model_place $place 
  	* @return void
  	*/
	public function showArticleAction(Tx_Wpj_Domain_Model_article $article) {
			
		$mediaArray = array();
		$medias = $article->getMedias();
		foreach ($medias as $media){
			//$url = $GLOBALS['TSFE']->cObj->IMG_RESOURCE	
			$mediaArray[] = array(
				'uid' => $media->getUid(),
				'description' => $media->getDescription(),
				'url' => $media->getPreviewUrl(),
			);
		}	
			
		$response = array(
			'title' => $article->getTitle(),
			'body' => $article->getBody(),
			'medias' => $mediaArray
		);
		
		return json_encode($response) ;
	}
	
	
	
	
	
	
}
?>