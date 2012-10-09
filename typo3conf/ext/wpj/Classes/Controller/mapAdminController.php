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
 * Controller manage map-views
 * This is an unfinished experimental feature to draw outlines for buildings and room 
 * All functionality is only for testing purposes
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_mapAdminController extends Tx_Wpj_Controller_protectedController {
	
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
		$this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
	}
	
	/**
	 * List action for this controller. Displays a map
     * 
	 */
	public function indexAction() {
		$places = $this->placeRepository->findAll();
		$this->view->assign('places', $places);
		$this->addGMapJS();
		$this->uriBuilder->setTargetPageType(10); // ajax
		$loadBuildingsUrl = 	$this->uriBuilder->uriFor('loadBuildings', array( ), 'mapAdmin');
		$loadChildrenUrl = 	$this->uriBuilder->uriFor('loadChildren', array( ), 'mapAdmin');
		$savePolygoneUrl = 	$this->uriBuilder->uriFor('savePolygone', array( ), 'mapAdmin');
		$additionalHeaderData = '
            <script type="text/javascript">
            <!--
                var loadChildrenUrl = 	"'.$loadChildrenUrl.'";
                var loadBuildingsUrl = 	"'.$loadBuildingsUrl.'";
                var savePolygoneUrl = 	"'.$savePolygoneUrl.'";
        	// -->
        	</script>';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
	}
	
	/**
	 * loads the buildings
     * 
  	 * @dontverifyrequesthash
	 */
	public function loadBuildingsAction() {
		$places = $this->placeRepository->findByAccuracy(7); // 7 = Building-Level
		$this->view->assign('places', $places);        
	}
	
	/**
	 * loads the childs of the buildings
     * 
  	 * @dontverifyrequesthash
	 */
	public function loadChildrenAction() {
		$place = $this->placeRepository->findByUid( $this->request->getArgument('place') );
		$places = $place->getChildren();
		$this->view->assign('places', $places);        
	}	

	/**
	 * Updates an existing place and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_place $place 
	 * @dontvalidate $place
  	 * @dontverifyrequesthash
	 */
	public function savePolygoneAction(Tx_Wpj_Domain_Model_place $place) {
		$this->placeRepository->update($place);
		return "success";
	}
	
	/**
  	*   	
  	* @return void
  	*/
	public function loadMapXmlAction() {
		$this->view->assign('article', $article);
	}
	
	private function addGMapJS() {
		$additionalHeaderData = '
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&amp;sensor=false"></script>
			<script type="text/javascript" src="typo3conf/ext/wpj/Resources/Public/map/mapAdmin.js"></script>
			<script type="text/javascript" src="typo3conf/ext/wpj/Resources/Public/map/mapEditor.js"></script>
			<script type="text/javascript" src="typo3conf/ext/wpj/Resources/Public/map/gui.js"></script>
			<script type="text/javascript" src="typo3conf/ext/wpj/Resources/Public/map/polygonEdit.js"></script>
';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
	}
	
}
?>