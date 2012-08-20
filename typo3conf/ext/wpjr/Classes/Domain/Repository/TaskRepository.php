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
 * Repository for Tx_Wpjr_Domain_Model_Task
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
 
class Tx_Wpjr_Domain_Repository_TaskRepository extends Tx_Extbase_Persistence_Repository {
	
	
	protected $defaultOrderings = array(
		'tx_wpjr_sorting ' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
	);
	
	/**
	 * @param Tx_Wpjr_Domain_Model_Rallye
	 * @return Tx_Wpjr_Domain_Model_Task objects
	 */
	public function findRootLevel($rallye) {
		$query = $this->createQuery();
		$query->matching($query->logicalAnd(
			array($query->equals('parent', 0), $query->equals('rallye', $rallye))
			)
		);
		return $query->execute();
	}
	
	/**
	 * 
	 * @return array an array of Tx_Wpjr_Domain_Model_Task objects
	 */
	public function findAllChildren(Tx_Wpjr_Domain_Model_Task $task) {
		$query = $this->createQuery();
		$query->matching($query->equals('parent', $task));
		$query->setOrderings(array('sorting' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		return $query->execute();
	}
	
	
	public function sortTasks(Tx_Wpjr_Domain_Model_Rallye $rallye, $ids){
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$sql = "";
		$index = 1;
		foreach ($ids as $id){
			$sql = "UPDATE `tx_wpjr_domain_model_task` SET tx_wpjr_sorting=$index ";
			$sql .= "WHERE `rallye`=".$rallye->getUid()." AND uid=".strval($id).";";
			$this->query->statement($sql)->execute();
			$index++;
		}
	}
}
?>