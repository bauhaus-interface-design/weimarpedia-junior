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
 * Controller for the media object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

// TODO: As your extension matures, you should use Tx_Extbase_MVC_Controller_ActionController as base class, instead of the ScaffoldingController used below.
class Tx_WpjV1_Controller_mediaController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * @var Tx_WpjV1_Domain_Repository_mediaRepository
	 */
	protected $mediaRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->mediaRepository = t3lib_div::makeInstance('Tx_WpjV1_Domain_Repository_mediaRepository');
	}
	/**
	 * List action for this controller. Displays all medias.
	 */
	public function indexAction() {
		$medias = $this->mediaRepository->findAll();
		$this->view->assign('medias', $medias);
	}

	/**
	 * Action that displays a single media
	 *
	 * @param Tx_WpjV1_Domain_Model_media $media The media to display
	 */
	public function showAction(Tx_WpjV1_Domain_Model_media $media) {
		$this->view->assign('media', $media);
	}

	/**
	 * Displays a form for creating a new media
	 *
	 * @param Tx_WpjV1_Domain_Model_media $newmedia A fresh media object taken as a basis for the rendering
	 * @dontvalidate $newmedia
	 */
	public function newAction(Tx_WpjV1_Domain_Model_media $newmedia = NULL) {
		$this->view->assign('newmedia', $newmedia);
	}

	/**
	 * Creates a new media and forwards to the index action.
	 *
	 * @param Tx_WpjV1_Domain_Model_media $newmedia A fresh media object which has not yet been added to the repository
	 */
	public function createAction(Tx_WpjV1_Domain_Model_media $newmedia) {
		$this->mediaRepository->add($newmedia);
		$this->flashMessageContainer->add('Your new media was created.');
		$this->redirect('index');
	}

	/**
	 * Displays a form to edit an existing media
	 *
	 * @param Tx_WpjV1_Domain_Model_media $media The media to display
	 * @dontvalidate $media
	 */
	public function editAction(Tx_WpjV1_Domain_Model_media $media) {
		$this->view->assign('media', $media);
	}

	/**
	 * Updates an existing media and forwards to the index action afterwards.
	 *
	 * @param Tx_WpjV1_Domain_Model_media $media The media to display
	 */
	public function updateAction(Tx_WpjV1_Domain_Model_media $media) {
		$this->mediaRepository->update($media);
		$this->flashMessageContainer->add('Your media was updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing media
	 *
	 * @param Tx_WpjV1_Domain_Model_media $media The media to be deleted
	 */
	public function deleteAction(Tx_WpjV1_Domain_Model_media $media) {
		$this->mediaRepository->remove($media);
		$this->flashMessageContainer->add('Your media was removed.');
		$this->redirect('index');
	}
	

	
}
?>