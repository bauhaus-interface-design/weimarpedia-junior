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
 * Controller for the school object
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_schoolController extends Tx_Wpj_Controller_protectedController {
	
	/**
	 * @var Tx_Wpj_Domain_Repository_schoolRepository
	 */
	protected $schoolRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->schoolRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_schoolRepository');
	}
	
	/**
	 * List action for this controller. Displays all schools.
	 */
	public function indexAction() {
		$schools = $this->schoolRepository->findAll();
		$this->view->assign('schools', $schools);
	}

	/**
	 * Action that displays a single school
	 *
	 * @param Tx_Wpj_Domain_Model_school $school The school to display
	 */
	public function showAction(Tx_Wpj_Domain_Model_school $school) {
		$this->view->assign('school', $school);
	}

	/**
	 * Displays a form for creating a new school
	 *
	 * @param Tx_Wpj_Domain_Model_school $newschool A fresh school object taken as a basis for the rendering
	 * @dontvalidate $newschool
	 */
	public function newAction(Tx_Wpj_Domain_Model_school $newschool = NULL) {
		$this->view->assign('newschool', $newschool);
	}

	/**
	 * Creates a new school and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_school $newschool A fresh school object which has not yet been added to the repository
	 */
	public function createAction(Tx_Wpj_Domain_Model_school $newschool) {
		$this->schoolRepository->add($newschool);
		$this->flashMessageContainer->add('Your new school was created.');
		$this->redirect('index');
	}

	/**
	 * Displays a form to edit an existing school
	 *
	 * @param Tx_Wpj_Domain_Model_school $school The school to display
	 * @dontvalidate $school
	 */
	public function editAction(Tx_Wpj_Domain_Model_school $school) {
		$this->view->assign('school', $school);
	}

	/**
	 * Updates an existing school and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpj_Domain_Model_school $school The school to display
	 */
	public function updateAction(Tx_Wpj_Domain_Model_school $school) {
		$this->schoolRepository->update($school);
		$this->flashMessageContainer->add('Your school was updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing school
	 *
	 * @param Tx_Wpj_Domain_Model_school $school The school to be deleted
	 */
	public function deleteAction(Tx_Wpj_Domain_Model_school $school) {
		$this->schoolRepository->remove($school);
		$this->flashMessageContainer->add('Your school was removed.');
		$this->redirect('index');
	}
	
}
?>