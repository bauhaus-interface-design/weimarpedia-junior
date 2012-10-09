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
 * Controller for the mediafile object
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_mediafileController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Repository_mediafileRepository
	 */
	protected $mediafileRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->allowOnlyIfLoggedIn();
		$this->mediafileRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_mediafileRepository');
	}
    
	/**
	 * List action for this controller. Displays all mediafiles.
	 */
	public function indexAction() {
		$mediafiles = $this->mediafileRepository->findAll();
		$this->view->assign('mediafiles', $mediafiles);
	}

	/**
	 * Action that displays a single mediafile
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $mediafile The mediafile to display
	 */
	public function showAction(Tx_Wpj_Domain_Model_mediafile $mediafile) {
		$this->view->assign('mediafile', $mediafile);
	}

	/**
	 * Displays a form for creating a new mediafile
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $newmediafile A fresh mediafile object taken as a basis for the rendering
	 * @dontvalidate $newmediafile
	 */
	public function newAction(Tx_Wpj_Domain_Model_mediafile $newmediafile = NULL) {
		$this->view->assign('newmediafile', $newmediafile);
	}

	/**
	 * Creates a new mediafile and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $newmediafile A fresh mediafile object which has not yet been added to the repository
	 */
	public function createAction(Tx_Wpj_Domain_Model_mediafile $newmediafile) {
		$this->mediafileRepository->add($newmediafile);
		$this->flashMessageContainer->add('Your new mediafile was created.');
		$this->redirect('index');
	}

	/**
	 * Displays a form to edit an existing mediafile
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $mediafile The mediafile to display
	 * @dontvalidate $mediafile
	 */
	public function editAction(Tx_Wpj_Domain_Model_mediafile $mediafile) {
		$this->view->assign('mediafile', $mediafile);
	}

	/**
	 * Updates an existing mediafile and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $mediafile The mediafile to display
	 */
	public function updateAction(Tx_Wpj_Domain_Model_mediafile $mediafile) {
		$this->mediafileRepository->update($mediafile);
		$this->flashMessageContainer->add('Your mediafile was updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing mediafile
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $mediafile The mediafile to be deleted
	 */
	public function deleteAction(Tx_Wpj_Domain_Model_mediafile $mediafile) {
		$this->mediafileRepository->remove($mediafile);
		$this->flashMessageContainer->add('Your mediafile was removed.');
		$this->redirect('index');
	}
	
}
?>