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
 * Controller for the author object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

// TODO: As your extension matures, you should use Tx_Extbase_MVC_Controller_ActionController as base class, instead of the ScaffoldingController used below.
class Tx_Wpj_Controller_authorController extends Tx_Wpj_Controller_protectedController {
	
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
		$this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->author = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	/**
	 * List action for this controller. Displays all authors.
	 */
	public function indexAction() {
		$authors = $this->authorRepository->findAll();
		$this->view->assign('authors', $authors);
	}

	/**
	 * Action that displays a single author
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to display
	 */
	public function showAction(Tx_Wpj_Domain_Model_author $author) {
		$this->view->assign('author', $author);
	}

	/**
	 * Displays a form for creating a new author
	 *
	 * @param Tx_Wpj_Domain_Model_author $newauthor A fresh author object taken as a basis for the rendering
	 * @dontvalidate $newauthor
	 */
	public function newAction(Tx_Wpj_Domain_Model_author $newauthor = NULL) {
		$newauthor = new Tx_Wpj_Domain_Model_author();
		$this->view->assign('newauthor', $newauthor);
	}

	/**
	 * Creates a new author and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_author $newauthor A fresh author object which has not yet been added to the repository
	 */
	public function createAction(Tx_Wpj_Domain_Model_author $newauthor) {
		$newauthor->setAdmin(1);
		$this->authorRepository->add($newauthor);
		$this->authorRepository->repairUsergroup(); // TODO: replace this hack, if exbase is ready
		$this->flashMessageContainer->add('Der Nutzer wurde angelegt.');
		$this->redirect('index');
	}

	/**
	 * Displays a form to edit an existing author
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to display
	 * @dontvalidate $author
	 */
	public function editAction(Tx_Wpj_Domain_Model_author $author) {
		$this->view->assign('author', $author);
	}

	/**
	 * Updates an existing author and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to display
	 */
	public function updateAction(Tx_Wpj_Domain_Model_author $author) {
		$this->authorRepository->update($author);
		$this->flashMessageContainer->add('Der Nutzer wurde aktualisiert.');
		$this->redirect('index');
	}


	/**
	 * Updates an existing author and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to display
	 */
	public function updatePasswordAction(Tx_Wpj_Domain_Model_author $author) {
		$password = $author->generatePassword();
		$author->setPassword(md5($password));
		$this->authorRepository->update($author);
		$this->view->assign('password', $password);
		$this->view->assign('author', $author);
	}
	
	/**
	 * Deletes an existing author
	 *
	 * @param Tx_Wpj_Domain_Model_author $author The author to be deleted
	 * @dontvalidate $author
	 */
	public function deleteAction(Tx_Wpj_Domain_Model_author $author) {
		$this->authorRepository->remove($author);
		$this->flashMessageContainer->add('Der Nutzer wurde entfernt.');
		$this->redirect('index');
	}
	
}
?>