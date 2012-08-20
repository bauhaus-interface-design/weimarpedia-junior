<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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
 * Controller for the RallyePlace object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Controller_RallyePlaceController extends Tx_Wpjr_Controller_protectedController {
	
	/**
	 * rallyePlaceRepository
	 * 
	 * @var Tx_Wpjr_Domain_Repository_RallyePlaceRepository
	 */
	protected $rallyePlaceRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->rallyePlaceRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_RallyePlaceRepository');
	}
	
	
		
	/**
	 * Displays all RallyePlaces
	 *
	 * @return string The rendered list view
	 */
	public function listAction() {
		$rallyePlaces = $this->rallyePlaceRepository->findAll();
		$this->view->assign('rallyePlaces', $rallyePlaces);
	}
	
		
	
		
	/**
	 * Creates a new RallyePlace and forwards to the list action.
	 *
	 * @param Tx_Wpjr_Domain_Model_RallyePlace $newRallyePlace a fresh RallyePlace object which has not yet been added to the repository
	 * @dontvalidate $newRallyePlace
	 * @return string An HTML form for creating a new RallyePlace
	 */
	public function createAction(Tx_Wpjr_Domain_Model_RallyePlace $newRallyePlace = NULL) {
		if( $newRallyePlace){
			$this->rallyePlaceRepository->add($newRallyePlace);
			$this->flashMessageContainer->add('Der Ort wurde angelegt.');
			$this->redirect('list');
		}
		else {
			$this->view->assign('newRallyePlace', $newRallyePlace);
		}
	}
	
		
	
	/**
	 * Updates an existing RallyePlace and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpjr_Domain_Model_RallyePlace $rallyePlace the RallyePlace to display
	 * @param boolean $isEdited is set to true, if the action is called after the form has been displayed
	 * @dontvalidate $rallyePlace
	 * @return string A form to edit a RallyePlace 
	 * @dontverifyrequesthash
	 */
	public function updateAction(Tx_Wpjr_Domain_Model_RallyePlace $rallyePlace, $isEdited = false) {
		if($isEdited){
			$this->rallyePlaceRepository->update($rallyePlace);
			$this->flashMessageContainer->add('Der Ort wurde aktualisiert.');
			$this->redirect('list');
		}
		$this->view->assign('rallyePlace', $rallyePlace);
	}
	
		
			/**
	 * Deletes an existing RallyePlace
	 *
	 * @param Tx_Wpjr_Domain_Model_RallyePlace $rallyePlace the RallyePlace to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Wpjr_Domain_Model_RallyePlace $rallyePlace) {
		$this->rallyePlaceRepository->remove($rallyePlace);
		$this->flashMessageContainer->add('Der Ort wurde entfernt.');
		$this->redirect('list');
	}
	
}
?>