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
 * Controller for the place object
 * provides admin views to manage places
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_placeController extends Tx_Wpj_Controller_protectedController {
	
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
	 * List action for this controller. Displays all places.
     * 
	 * @param Tx_Wpj_Domain_Model_place $lastplace 
	 * @dontvalidate $lastplace
	 */
	public function indexAction(Tx_Wpj_Domain_Model_place $lastplace = NULL) {
		$root = $this->placeRepository->findRoot();
		$this->view->assign('root', $root[0] );  
		$places = $this->placeRepository->findByAccuracy(5); // for shortcut select box | 5 -> Level City
		$this->view->assign('places', $places );   
		if ($lastplace == NULL) $lastplace = $this->placeRepository->findOneByName("Weimar");
		$this->view->assign('lastPlaceParent', $lastplace->getParent());
		$this->view->assign('lastPlaces', $lastplace->getParent()->getParent()->getChildren());     
	}
	
	/**
	 * Displays a form for creating a new place
	 *
	 * @param Tx_Wpj_Domain_Model_place $newplace A fresh place object taken as a basis for the rendering
	 * @param Tx_Wpj_Domain_Model_place $parentPlace
	 * @dontvalidate $newplace
	 */
	public function newAction(Tx_Wpj_Domain_Model_place $parentPlace, Tx_Wpj_Domain_Model_place $newplace = NULL ) {
		$newplace = new Tx_Wpj_Domain_Model_place();
		$newplace->setParent($parentPlace);
		$this->view->assign('newplace', $newplace);
	}

	/**
	 * Creates a new place and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_place $newplace A fresh place object which has not yet been added to the repository
	 */
	public function createAction(Tx_Wpj_Domain_Model_place $newplace) {
		$this->placeRepository->add($newplace);
		$pM = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
    	$pM->persistAll();
		$this->flashMessageContainer->add($newplace->getName().' wurde erstellt.');
		//$this->redirect('index', NULL, NULL, array('lastPlace' => $newplace));
	}

	/**
	 * Displays a form to edit an existing place
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place to display
	 * @dontvalidate $place
	 */
	public function editAction(Tx_Wpj_Domain_Model_place $place) {
			
		$dirpath = t3lib_div::getFileAbsFileName('uploads/wpj/placeIcons');
		$dh = opendir($dirpath);
  		$placeIcons = array();
  		if ($dh){
	  		$placeIcons = array();
	  		while (false !== ($file = readdir($dh))) {
				if (!is_dir("$dirpath/$file")) {
					$label = $file;
					$placeIcons[$file] = $label;
					
				}
			}
	     	closedir($dh);
		}
	  	
		if ($place->getAccuracy() == 8){ // floors
			$dirpath = t3lib_div::getFileAbsFileName('uploads/wpj/floormaps');
			$dh = opendir($dirpath);
	  		$floorPlans = array();
	  		if ($dh){
		  		$placeIcons = array();
		  		while (false !== ($file = readdir($dh))) {
					if (!is_dir("$dirpath/$file")) {
						$label = $file;
						$floorPlans[$file] = $label;
						
					}
				}
		     	closedir($dh);
			}
			$this->view->assign('floorPlans', $floorPlans);
		}
		
		$this->view->assign('placeIcons', $placeIcons);
		$this->view->assign('place', $place);
	}

	/**
	 * Updates an existing place and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place to display
	 */
	public function updateAction(Tx_Wpj_Domain_Model_place $place) {
		$this->placeRepository->update($place);
		$this->flashMessageContainer->add($place->getName().' wurde aktualisiert.');
		$this->redirect('index', NULL, NULL, array('lastplace' => $place));
	}

	/**
	 * Deletes an existing place
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place to be deleted
	 */
	public function deleteAction(Tx_Wpj_Domain_Model_place $place) {
		$this->placeRepository->remove($place);
		$this->flashMessageContainer->add($place->getName().' wurde entfernt.');
		$this->redirect('index', NULL, NULL, array('lastPlace' => $place->getParent()));
	}
	
	/**
	 * Returns childs of a place as html select options
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place 
	 */
	public function loadChildOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		$this->view->assign('children', $place->getChildren());
	}
	
	/**
	 * Returns childs of a place as json
	 *
	 */
	public function loadChildrenAction() {
		$parentUid = (int) $_GET['root'];
		if (!$parentUid > 0) $parentUid = 7;
		$parentPlace = $this->placeRepository->findByUid( $parentUid );
		$this->view->assign('children', $parentPlace->getChildren());
		$this->view->assign('parentPlace', $parentPlace);
	}

	
	/**
	 * Returns places back to root as html select options
	 *
	 * @param Tx_Wpj_Domain_Model_place $place The place 
	 */
	public function loadPathToRootOptionsAction(Tx_Wpj_Domain_Model_place $place) {
		$this->view->assign('parent', $place->getParent());
		$this->view->assign('options', $place->pathToRoot($place));
	}
	
	
	
	/**
	 * Creates a new place from data provided by a geolocalization service
	 *
	 */
	public function createPlacesAction() {
		$placeData = $_POST['placeData'];
		$createNow = ($_POST['createNow'] == "true")? true:false;	
		// found existing place
		for ($i = count($placeData)-1; $i>2; $i--){
			$p = $placeData[$i];
			if ($p != 'undefined'){
				$place = $this->placeRepository->findByNameAndAccuracy(($p), $i);
				if ($place) {
					$parentPlace = $place;	
					break;
				}
			}
		}
		if ($i > 2) {
			// reverse
			$output = "Bekannter Ausgangspunkt ist ".$parentPlace->getName()."\nNeue Orte:";
			for ($i = $i+1; $i < count($placeData); $i++){
				$p = $placeData[$i];
				$output .= "\n - ".$p." (Ebene ".$i.")";
				
				if ($createNow){
					$newplace = new Tx_Wpj_Domain_Model_place();
					$newplace->setParent($parentPlace);
					$newplace->setName($p);
					$parentPlace = $newplace;
					
					$this->placeRepository->add($newplace);
					$pM = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			    	$pM->persistAll();
					$log .= "\n".$p." UID:".$newplace->getUid()." ".$newplace->getAccuracyLabel();
				} 
			}
				
			echo nl2br($output);
			if ($createNow) echo nl2br($log);
		}else {
			echo "nichts gefunden ".$i;
		}
		exit();
	}
}
?>