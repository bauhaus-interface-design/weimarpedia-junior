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
 * Controller to create multiple authors 
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_authorWizardController extends Tx_Wpj_Controller_protectedController {
	
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
		$this->schoolRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_schoolRepository');
	}
	
	/**
	 * Displays a form for creating a new school
	 *
	 * @param Tx_Wpj_Domain_Model_school $newschool A fresh school object taken as a basis for the rendering
	 * @dontvalidate $newschool
	 */
	public function step1Action(Tx_Wpj_Domain_Model_school $newschool = NULL) {
		$this->clearSessionData("authors");
		$this->clearSessionData("school");
		$this->view->assign('newschool', $newschool);
		$schools = $this->schoolRepository->findAll();
		$this->view->assign('schools', $schools);
	}

	/**
	 * Creates a new school and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_school $newschool A fresh school object which has not yet been added to the repository
	 */
	public function step1CreateAction(Tx_Wpj_Domain_Model_school $newschool) {
		$this->schoolRepository->add($newschool);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
   		$persistenceManager->persistAll();
		$this->storeSessionData("school", $newschool->getUid()); 
		$this->storeSessionData( "prefix", substr($newschool->getName(), 0,10)."-" );
		$this->redirect('step2');
	}
	
	/**
	 * Saves school choosed by the select field and redirects to step 2
	 */
	public function step1SelectAction() {
		$schoolUid = $this->request->getArgument('selectedSchool');
		$this->storeSessionData("school", $schoolUid); 
		$school = $this->schoolRepository->findByUid($schoolUid);
		$this->storeSessionData( "prefix", substr($school->getName(), 0,10)."-" );
		$this->redirect('step2');
	}
	
	/**
	 * Displays a form for creating a new author
	 *
	 * @param Tx_Wpj_Domain_Model_author $newauthor A fresh author object taken as a basis for the rendering
	 * @dontvalidate $newauthor
	 */
	public function step2Action(Tx_Wpj_Domain_Model_author $newauthor = NULL) {
		$newauthor = new Tx_Wpj_Domain_Model_author();
		$name = $this->loadSessionData("prefix");
		$name .= count($this->loadSessionData("authors"))+1;
		$newauthor->setName($name);
		$newauthor->setCompany( $this->loadSessionData("classlevel") );
		$newauthor->setFax( $this->loadSessionData("program") );
		$this->view->assign('newauthor', $newauthor);
	}

	/**
	 * Creates a new author and forwards to the index action.
	 *
	 * @param Tx_Wpj_Domain_Model_author $newauthor A fresh author object which has not yet been added to the repository
	 */
	public function step2ProcessAction(Tx_Wpj_Domain_Model_author $newauthor) {
		$this->storeSessionData("classlevel", $newauthor->getCompany()); 
		$this->storeSessionData("program", $newauthor->getFax()); 
		
		// add school
		$newauthor->setSchool( $this->loadSessionData("school") );
		// create password
		$password = $newauthor->generatePassword();
		$newauthor->setPassword(md5($password));
		$username = $newauthor->generateUsername();
		// create username
		$newauthor->setUsername($username);
		$newauthor->setStarttimeAndDuration( time() , 60*60*24*365); // valid 1 year from now 
		// add group
		$newauthor->addStandardGroup();
		// add adminlevel
		$newauthor->setAdmin(1);
		// add new author to repository
		$this->authorRepository->add($newauthor);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
   		$persistenceManager->persistAll();
   		
		$this->authorRepository->repairUsergroup(); // TODO: replace this hack, if exbase is ready
		
		$authorSessionStorage = $this->loadSessionData("authors");
		if (gettype($authorSessionStorage)!="array") $authorSessionStorage = array();
		array_push($authorSessionStorage, array(
			'i' => count($authorSessionStorage),
			'uid' => $newauthor->getUid(), 
		 	'username' => $username,
			'password' => $password,
			'name' => $newauthor->getName(),
			'address' => $newauthor->getAddress(),
			'email' => $newauthor->getEmail(),
			'dates' => 'vom '.date('d.m.y', $newauthor->getStarttime()).' bis '.date('d.m.y', $newauthor->getEndtime()),
			
		));
		$this->storeSessionData("authors", $authorSessionStorage);
		
		if ( $this->request->getArgument('status') == 'Fertig' ) $this->redirect('step3');
		else $this->redirect('step2');
	}
	
    /**
     * Shows the created logins
     *
     */
	public function step3Action() {
		$authorSessionStorage = $this->loadSessionData("authors");
		$this->view->assign('authors', $authorSessionStorage);
		
		$schoolUid = $this->loadSessionData("school");
		$school = $this->schoolRepository->findByUid($schoolUid);
		$this->view->assign('school', $school);
		
		$admin = $this->authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
		$this->view->assign('admin', $admin);
	}
	
	
	
	
	/**
	 * Loads data from session 
	 * @return String
	 */
	protected function loadSessionData($key) {
		return $GLOBALS['TSFE']->fe_user->getKey('ses', "tx_wpj_".$key);
	}
	
	/**
	 * Stores data to session.
	 * @return void
	 */
	protected function storeSessionData($key,$value) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', "tx_wpj_".$key, $value);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}
 
    /**
     * Deletes session data.
     * @return void
     */
	protected function clearSessionData($key) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', "tx_wpj_".$key, array());
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}
}
?>