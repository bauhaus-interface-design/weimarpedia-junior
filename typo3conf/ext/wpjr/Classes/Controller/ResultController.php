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
 * Controller for the Result object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Controller_ResultController extends Tx_Wpjr_Controller_protectedController {
	
	/**
	 * resultRepository
	 * 
	 * @var Tx_Wpjr_Domain_Repository_ResultRepository
	 */
	protected $resultRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		if (!$this->actionMethodName == 'importAction') $this->allowOnlyAuthorWithMinAdminLevel(10);
		$this->resultRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_ResultRepository');
	}
	
	
		
	/**
	 * Displays ResultSets grouped by day and Rallye
	 *
	 * @return string The rendered list view
	 */
	public function listAction() {
		$resultSets = $this->resultRepository->findAllSets();
		$this->view->assign('resultSets', $resultSets);
	}
	
		
	/**
	 * Displays single Result
	 * @param Tx_Wpjr_Domain_Model_ResultSet
	 * @return string The rendered view
	 */
	public function showAction(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		$this->view->assign('resultSet', $resultSet);
	}

		
	/**
	 * Displays single Result
	 * @param Tx_Wpjr_Domain_Model_ResultSet
	 * @return string The rendered view
	 */
	public function reportAction(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		$this->resultRepository->collectByTasks($resultSet);
		$this->view->assign('resultSet', $resultSet);
	}
		
	/**
	 * Displays single Result
	 * @param Tx_Wpjr_Domain_Model_ResultSet
	 * @return string The rendered view
	 */
	public function presentAction(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		$this->resultRepository->collectByTasks($resultSet); // adds an additional attribute tasks to $resultSet
		$this->view->assign('resultSet', $resultSet);
	}
	
	/**
	 * Deletes an existing resultSet
	 *
	 * @param Tx_Wpjr_Domain_Model_ResultSet $resultSet the Resultset to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		$result = $this->resultRepository->deleteResultSet($resultSet);
		
		$this->flashMessageContainer->add('Das Auswertungsset wurde entfernt.');
		$this->redirect('list');
	}
	
	
	/**
	 * Import from mobile device
	 * annotate @json to required attributes in model
	 * @return void
	 */
	public function importAction() {
		// decode arrays
		$info = json_decode(stripslashes(utf8_encode($_POST['info'])));
		$tasks = json_decode(stripslashes(utf8_encode($_POST['tasks'])));
		$tasks = $tasks->tasks;
		// create results
		
		$debug = array();
		foreach ($tasks as $taskJson){
			$result = new Tx_Wpjr_Domain_Model_Result();
			$debug[] = $result->importTask( $taskJson );
			
			// info attributes
			$result->setUser( $info->user );
			$result->setLogin( $info->login );
			$result->setGroupname( $info->groupname );
			
			$this->resultRepository->add($result);
		}
			
		$pM = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
    	$pM->persistAll();
    	
    	//echo "\n\n resultID ".$result->getUid()." \n\n";
    	
		// test output
		ob_end_clean();
		
		/*
		 
		echo "\n\nCONTENT\n\n";
		var_dump($debug);
		
		echo "\n\njson_decode info\n\n";
		var_dump( json_decode(stripslashes(utf8_encode($_POST['info']))) );
		
		echo "\n\njson_decode tasks\n\n";
		var_dump( json_decode(stripslashes(utf8_encode($_POST['tasks']))) );
		
		echo "\n\njson_decode tasks nonstripped\n\n";
		var_dump( serialize(utf8_encode($_POST['tasks'])) );
		
		echo "\n\nFILES\n\n";
		var_dump($_FILES);
		*/

		
		
		
		
    	
		// output in var
		$output = ob_get_contents();
		
		// save to file
		$fp = fopen("debug.txt", "w");
		fputs($fp, $output);
		fclose($fp);
    	
    	
		// answer request
		ob_clean();
		header("HTTP/1.0 200 OK");
		header('Content-Type: text/plain');
		echo $output;
		
		// header("HTTP/1.0 400 Bad Request");
		exit();
      
	}
	
}
?>