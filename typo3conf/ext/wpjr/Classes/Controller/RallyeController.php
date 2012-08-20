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
 * Controller for the Rallye object and its Tasks
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Controller_RallyeController extends Tx_Wpjr_Controller_protectedController {
	
	/**
	 * rallyeRepository
	 * 
	 * @var Tx_Wpjr_Domain_Repository_RallyeRepository
	 */
	protected $rallyeRepository;

	/**
	 * taskRepository
	 * 
	 * @var Tx_Wpjr_Domain_Repository_TaskRepository
	 */
	protected $taskRepository;
	
	/**
	 * rallyePlaceRepository
	 * 
	 * @var Tx_Wpjr_Domain_Repository_RallyePlaceRepository
	 */
	protected $rallyePlaceRepository;
	
	
	/**
	 * @var Tx_Extbase_Property_Mapper
	 */
	protected $propertyMapper;

	/**
	 * @var Tx_Wpjr_Utility_PropertyMapper
	 */
	protected $utilityPropertyMapper;
	
	/**
	 * @param Tx_Extbase_Property_Mapper $propertyMapper
	 */
	public function injectPropertyMapper(Tx_Extbase_Property_Mapper $propertyMapper) {
		$this->propertyMapper = $propertyMapper;
	}

	/**
	 * @param Tx_Wpjr_Utility_PropertyMapper $utilityPropertyMapper
	 */
	public function injectUtilityPropertyMapperMapper(Tx_Wpjr_Utility_PropertyMapper $utilityPropertyMapper) {
		$this->utilityPropertyMapper = $utilityPropertyMapper;
	}
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		if ($this->actionMethodName == 'listJsonAction'|| $this->actionMethodName == 'exportAction') {
			//
		}else $this->allowOnlyAuthorWithMinAdminLevel(10);
		
		$this->rallyeRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_RallyeRepository');
		$this->taskRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_TaskRepository');
		$this->rallyePlaceRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_RallyePlaceRepository');
	}
	
	
		
	/**
	 * Displays all Rallyes
	 *
	 * @return string The rendered list view
	 */
	public function listAction() {
		$rallyes = $this->rallyeRepository->findAll();
		$this->view->assign('rallyes', $rallyes);
		$hiddenRallyes = $this->rallyeRepository->findAllHidden();
		$this->view->assign('hiddenRallyes', $hiddenRallyes);
	}
	
	/**
	 * Displays all Rallyes
	 *
	 * @return string The rendered list view
	 */
	public function listJsonAction() {
		$rallyes = $this->rallyeRepository->findAll();
		
		$source = array(); 
		foreach ($rallyes as $rallye){
			array_push($source, array(
				"name" => utf8_encode($rallye->getName()),
				"description" => utf8_encode($rallye->getDescription()) ,
				"url" => $this->uriBuilder->uriFor('export', array( "rallye" => $rallye->getUid() ))
			));
		}
		$json = json_encode($source);
		
		//header('Content-Type: application/json');
    	ob_clean();
    	//var_dump($debug);
    	echo $json;
    	exit;
	}	
		
	/**
	 * Tx_Wpjr_Domain_Model_Rallye $rallye
	 *
	 * @return string 
	 * @dontvalidate $rallye
	 */
	public function editAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->view->assign('rallye', $rallye);
	}
	
		
	/**
	 * Creates a new Rallye and forwards to the list action.
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $newRallye a fresh Rallye object which has not yet been added to the repository
	 * @return string An HTML form for creating a new Rallye
	 * 
	 */
	public function createAction(Tx_Wpjr_Domain_Model_Rallye $newRallye = NULL) {
		if( $newRallye){
			$newRallye->setAuthor($GLOBALS["TSFE"]->fe_user->user['uid']);
			$this->rallyeRepository->add($newRallye);
			$this->flashMessageContainer->add('Die Rallye wurde erstellt.');
			$this->redirect('list');
		}
		else {
			$this->view->assign('newRallye', $newRallye);
		}
	}
	
		
	
	/**
	 * Updates an existing Rallye and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye the Rallye to display
	 * @param boolean $isEdited is set to true, if the action is called after the form has been displayed	 
	 * @return string A form to edit a Rallye 
	 * 
	 */
	public function updateAction(Tx_Wpjr_Domain_Model_Rallye $rallye, $isEdited = false) {
		if($isEdited){
			$this->rallyeRepository->update($rallye);
			$this->flashMessageContainer->add('Die Rallye wurde aktualisiert.');
			$this->redirect('list');
		}
		$this->view->assign('rallye', $rallye);
	}
	
		
	/**
	 * Deletes an existing Rallye
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye the Rallye to be deleted
	 * @return void
	 * @dontvalidate $rallye
	 */
	public function deleteAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->rallyeRepository->remove($rallye);
		$this->flashMessageContainer->add('Die Rallye wurde entfernt.');
		$this->redirect('list');
	}
	
	
	/**
	 * 
	 * Managing Tasks
	 * 
	 */
	
	
	/**
	 * Displays all Tasks
	 * 
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @return string The rendered list view
	 */
	public function listTasksAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->view->assign('rallye', $rallye);
		$tasks = $this->taskRepository->findByRallye($rallye); // TODO: fix connection rallye->task
		$this->view->assign('tasks', $tasks);
		
		// url for ajax-sorting needed (not possible in fluid-template because of {}-parsing)
		$this->uriBuilder->setTargetPageType(10); // ajax
		$sortUrl = $this->uriBuilder->uriFor('sortTasks', array( "rallye" => $rallye->getUid() ));
		$additionalHeaderData = '
            <script type="text/javascript">
            <!--
                var sortUrl = 	"'.$sortUrl.'";
        	// -->
        	</script>';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
	}
	
		
	/**
	 * Creates a new Task and forwards to the list action.
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @param Tx_Wpjr_Domain_Model_Task $newTask a fresh Task object which has not yet been added to the repository
	 * @return string An HTML form for creating a new Task
	 * @dontvalidate $newTask
	 * @dontvalidate $rallye
	 */
	public function createTaskAction(Tx_Wpjr_Domain_Model_Rallye $rallye, Tx_Wpjr_Domain_Model_Task $newTask = NULL) {
		$this->view->assign('rallye', $rallye);
		
		// rallyePlaces
		$this->view->assign('rallyePlaces', $this->addRallyePlacesWithBlank());

		if( $newTask){
			$this->taskRepository->add($newTask);
			$this->flashMessageContainer->add('Die Aufgabe wurde angelegt.');
			$this->redirect('listTasks',NULL,NULL,array('rallye'=>$rallye));
		}
		else {
			$this->view->assign('resultTypes', Tx_Wpjr_Domain_Model_Task::getResultTypesOptions());
			$this->view->assign('newTask', $newTask);
		}
	}
	
		
	
	/**
	 * Updates an existing Task and forwards to the index action afterwards.
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @param Tx_Wpjr_Domain_Model_Task $task the Task to display
	 * @param boolean $isEdited is set to true, if the action is called after the form has been displayed
	 * @return string A form to edit a Task 
	 * @dontverifyrequesthash
	 */
	public function updateTaskAction(Tx_Wpjr_Domain_Model_Rallye $rallye, Tx_Wpjr_Domain_Model_Task $task, $isEdited = false) {
		$this->view->assign('rallye', $rallye);
		
		if($isEdited){
			$place = $_POST['tx_wpjr_pi1']['task']['place'];
			if ($place == 0) $task->removePlace();
			$this->taskRepository->update($task);
			$this->flashMessageContainer->add('Die Aufgabe wurde aktualisiert.');
			$this->redirect('listTasks',NULL,NULL,array('rallye' => $rallye));
		}
		$this->view->assign('rallyePlaces', $this->addRallyePlacesWithBlank());
		$this->view->assign('resultTypes', Tx_Wpjr_Domain_Model_Task::getResultTypesOptions());
		$this->view->assign('task', $task);
	}
	
	/**
	 * Resorts tasks 
	 * recieves array of ids
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @return string success
	 */
	public function sortTasksAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
			$this->taskRepository->sortTasks($rallye, explode("," , $this->request->getArgument('ids')) );
			return "success ";
	}		
	
	/**
	 * Deletes an existing Task
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @param Tx_Wpjr_Domain_Model_Task $task the Task to be deleted
	 * @return void
	 */
	public function deleteTaskAction(Tx_Wpjr_Domain_Model_Rallye $rallye, Tx_Wpjr_Domain_Model_Task $task) {
		$this->view->assign('rallye', $rallye);
		$this->taskRepository->remove($task);
		$this->flashMessageContainer->add('Die Aufgabe wurde entfernt.');
		$this->redirect('listTasks',NULL,NULL,array('rallye' => $rallye));
	}
	
	
	/**
	 * Exports Rallye and Tasks including images as JSON
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @return string json 
	 */
	public function exportAction(Tx_Wpjr_Domain_Model_Rallye $rallye){
		// tasks
		$tasks = $rallye->getTasks();
		$taskArray = array();
		$rallyePlacesArray = array();
		foreach ($tasks as $task){
			 $_task = $this->utilityPropertyMapper->getValuesByAnnotation($task);
			 $place = $task->getPlace();
			 if ($place){
				 $_task['place'] = $place->getUid();
				 $rallyePlacesArray[$place->getUid()] = $this->utilityPropertyMapper->getValuesByAnnotation($place);
			 }
			 $taskArray[] = $_task;
		}
		
		$source = array(
			"rallye" => $this->utilityPropertyMapper->getValuesByAnnotation($rallye),
			"tasks" => $taskArray,
			"rallyePlaces" => $rallyePlacesArray,
		);
		
		$json = json_encode($source);
		//$json = json_encode($rallyePlacesArray);
		
		
    	ob_clean();
		//header('Content-Type: application/json; charset=utf-8');
		header("Content-Type: text/html; charset=utf-8");
		
		//echo $rallye->getName();
		echo $json;
    	exit;	
	}
	

	/**
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @return string success
	 */
	public function activateAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$rallye->setActive(1);
		$this->rallyeRepository->update($rallye);
		$this->flashMessageContainer->add('Die Rallye wurde aktiviert.');
		$this->redirect('list');
	}
	
	/**
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * @return string success
	 */
	public function deactivateAction(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$rallye->setActive(0);
		$this->rallyeRepository->update($rallye);
		$this->flashMessageContainer->add('Die Rallye wurde deaktiviert.');
		$this->redirect('list');
	}	
	
	
	
	/**
	 * options for place-selectfield
	 * @param 
	 * @return 
	 */
	private function addRallyePlacesWithBlank(){
		$rallyePlaces = $this->rallyePlaceRepository->findAll();
		return array_merge((array("0" => " - ohne - ")), $rallyePlaces->toArray()); 
	}
}
?>