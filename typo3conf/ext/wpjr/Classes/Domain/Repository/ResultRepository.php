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
 * Repository for Tx_Wpjr_Domain_Model_Result
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
 
class Tx_Wpjr_Domain_Repository_ResultRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Group results by day and rallye
	 * 
	 * @return 
	 */
	public function findAllSets() {
		$rallyeRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_RallyeRepository');
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$sql = '
			SELECT DATE(FROM_UNIXTIME(tstamp)) date, rallye
			FROM `tx_wpjr_domain_model_result` 
			GROUP BY date,rallye 
			ORDER BY tstamp DESC';
		
		$results = $this->query->statement($sql)->execute();
		
		// query metadata and build resultset objects
		foreach ($results as $result){
			$resultSet = new Tx_Wpjr_Domain_Model_ResultSet(
				strtotime($result['date']), strtotime($result['date'])+60*60*24, $rallyeRepository->findByUid($result['rallye']) 
				);
			$this->metaInfoForSet($resultSet);
			$return[] = $resultSet;
		}
		return $return;
		
	}
	
	/**
	 * Meta-Info for list view
	 * @return 
	 */
	public function metaInfoForSet(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$sql = '
			SELECT task, COUNT(*) total
			FROM `tx_wpjr_domain_model_result` 
			WHERE tstamp>'.$resultSet->getTsBegin().' AND tstamp<'.$resultSet->getTsEnd().' AND rallye='.$resultSet->getRallye()->getUid().'
			GROUP BY task 
			ORDER BY task';
		
		$results = $this->query->statement($sql)->execute();
		
		$tasks = array();
		foreach ($results as $result){
			$tasks[] = array('id' => $result['task'], 'total' => $result['total']);
		}
		$resultSet->addMeta("tasks", $tasks);
		
		$sql = '
			SELECT login, COUNT(*) total
			FROM `tx_wpjr_domain_model_result` 
			WHERE tstamp>'.$resultSet->getTsBegin().' AND tstamp<'.$resultSet->getTsEnd().' AND rallye='.$resultSet->getRallye()->getUid().'
			GROUP BY login 
			ORDER BY login';
		
		$results = $this->query->statement($sql)->execute();
		$logins = array();
		foreach ($results as $result){
			$logins[] = array('login' => $result['login'], 'total' => $result['total']);
		}
		$resultSet->addMeta("logins", $logins);
	}
	
	
	
	/**
	 * this extends $resultset with meta-infos for the presentation view
	 * 
	 * meta.results.tasks[i]	task
	 * 							results[j]
	 * 
	 * meta.results.users[j]	photo
	 * 							name
	 * 
	 * @return 
	 */
	public function collectByTasks(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {
		// query ordered Tasks from Rallye
		$taskRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_TaskRepository');
		$tasksResults = $taskRepository->findByRallye($resultSet->getRallye());
		
		// query results for each task with result 
		$tasks = array();
		$users = array();
		foreach ($tasksResults as $task){
			if ($task->getResulttype() != ''){
			
				$query = $this->createQuery();
				$query->matching($query->logicalAnd(
					array(
						$query->equals('task', $task->getUid()),
						$query->greaterThan('tstamp', $resultSet->getTsBegin()),
						$query->lessThan('tstamp', $resultSet->getTsEnd())
					)
				));
				$query->setOrderings(array('login' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
				$query->setLimit(20);
				$queryresults = $query->execute();
				
	
				//if () 
				$queryArray = $queryresults->toArray();
				
				if ($task->getResulttype() == 'userphoto'){
					for($i=0;$i<count($queryArray);$i++){
						if (!$users[$i])	$users[$i] = array();
						$users[$i]['photo'] = $queryArray[$i]->getPhoto();
					}
					
				} else if ($task->getResulttype() == 'username') {
					for($i=0;$i<count($queryArray);$i++){
						if (!$users[$i])	$users[$i] = array();
						$users[$i]['name'] = $queryArray[$i]->getText();
					}
					
				} else {
					$tasks[] = array(
						'task' => $task,
						//'query' => serialize($resultSet),
						'results' => $queryArray
					);
				}
				
			}
		}
		$resultSet->addMeta("tasks", $tasks);
		$resultSet->addMeta("users", $users);
	}
	
	
	/**
	 * this extends $resultset with meta-infos for the presentation view
	 * 
	 * @return 
	 */
	public function deleteResultSet(Tx_Wpjr_Domain_Model_ResultSet $resultSet) {			
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$sql = '
			DELETE
			FROM `tx_wpjr_domain_model_result` 
			WHERE tstamp>'.$resultSet->getTsBegin().' AND tstamp<'.$resultSet->getTsEnd().' AND rallye='.$resultSet->getRallye()->getUid().'
			';
		
		$results = $query->statement($sql)->execute();
	}
}
?>