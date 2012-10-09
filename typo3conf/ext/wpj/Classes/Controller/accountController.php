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
 * Controller to manage current user profile
 * see session controller for login and logout actions
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_accountController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Model_author
	 */
	protected $author;

	/**
	 * @var Tx_Wpj_Domain_Repository_authorRepository
	 */
	protected $authorRepository;

	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->allowOnlyAuthorWithMinAdminLevel(1);
		$this->authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	
	/**
  	* Shows personal profile page with option links (create avatar image, change group name...)
  	*/
	public function indexAction() {
		$this->view->assign('author', $this->author);
	}	
	
	
	/**
	 * Displays a form to edit profile attributes like group name or email
	 */
	public function editAction() {
		$this->view->assign('author', $this->author);
	}

	/**
	 * Updates an existing author and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to update
	 */
	public function updateAction(Tx_Wpj_Domain_Model_author $author) {
		$this->authorRepository->update($author);
		$this->flashMessageContainer->add('Das Profil wurde aktualisiert.');
		$this->redirect('index'); 
	}
	

	/**
	 * Displays a form to upload or create an avatar image (using adobe flash)
	 *
	 */
	public function avatarFormAction() {
		$uploadAvatarRawUrl = 	$this->uriBuilder->uriFor('uploadAvatarRaw');
		$this->view->assign('uploadAvatarRawUrl', urlencode($uploadAvatarRawUrl));
		$redirectUrl = 	$this->uriBuilder->uriFor('index');
		$this->view->assign('redirectUrl', urlencode($redirectUrl));
		$this->view->assign('author', $this->author);
	}
	
	/**
	 * receives an jpg-stream from flash and saves as image
	 * via $GLOBALS["HTTP_RAW_POST_DATA"]
     * 
     * @return string success | failed
	 */
	public function uploadAvatarRawAction() {
		if ( isset ( $GLOBALS["HTTP_RAW_POST_DATA"] )) {
		    $filename = $this->author->getUid().".jpg";
		    $path = $this->author->getAvatarAbsPath()."/";
		    $fp = fopen( $path.$filename,"wb");
		    fwrite( $fp, $GLOBALS[ 'HTTP_RAW_POST_DATA' ] );
		    fclose( $fp );
			return "success";
		}
		return "failed";
	}
	
	
	/**
	 * uploads the avatar image file
     * redirects to index
	 *
	 */
	public function uploadAvatarFileAction() {
		if ($_FILES['tx_wpj_pi1']) { 
			// create file
			$filename = $this->author->getUid().".jpg";
		    $path = $this->author->getAvatarAbsPath()."/".$filename;
			$result = t3lib_div::upload_copy_move( $_FILES['tx_wpj_pi1']['tmp_name']['account']['avatarFile'], $path );
	 		
			$this->flashMessageContainer->add($result.'Dein Bild wurde hochgeladen. '.$path);
		}
		$this->redirect('index');
	}
	
}
?>