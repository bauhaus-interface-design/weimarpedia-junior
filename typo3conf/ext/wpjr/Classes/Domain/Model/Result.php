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
 * Result
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Domain_Model_Result extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * user
	 *
	 * @var integer $user
	 */
	protected $user;

	/**
	 * content
	 *
	 * @var string $content
	 */
	protected $content;

	/**
	 * timestamp
	 *
	 * @var integer $timestamp
	 */
	protected $timestamp;

	/**
	 * task
	 *
	 * @var Tx_Wpjr_Domain_Model_Task $task
	 */
	protected $task;

	/**
	 * rallye
	 *
	 * @var Tx_Wpjr_Domain_Model_Rallye rallye
	 */
	protected $rallye;
	
	/**
	 * groupname
	 *
	 * @var string $groupname
	 */
	protected $groupname;
	
	/**
	 * login
	 *
	 * @var string $login
	 */
	protected $login;
	
	
	
	
	
	
	/**
	 * Setter for user
	 *
	 * @param integer $user user
	 * @return void
	 */
	public function setUser($user) {
		$this->user = $user;
	}

	/**
	 * Getter for user
	 *
	 * @return integer user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Setter for content
	 *
	 * @param string $content content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string content
	 */
	public function getContent() {
		return $this->content;
	}
	

	/**
	 * Getter for content
	 *
	 * @return string content
	 */
	public function getPhoto() {
		$json = json_decode($this->content);
		return $json->photo;
	}
	public function getText() {
		$json = json_decode($this->content);
		return utf8_decode($json->content);
	}
	

	/**
	 * Setter for timestamp
	 *
	 * @param integer $timestamp timestamp
	 * @return void
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

	/**
	 * Getter for timestamp
	 *
	 * @return integer timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * Setter for task
	 *
	 * @param Tx_Wpjr_Domain_Model_Task $task task
	 * @return void
	 */
	public function setTask(Tx_Wpjr_Domain_Model_Task $task) {
		$this->task = $task;
	}

	/**
	 * Getter for task
	 *
	 * @return Tx_Wpjr_Domain_Model_Task task
	 */
	public function getTask() {
		return $this->task;
	}

	/**
	 * Setter for rallye
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye rallye
	 * @return void
	 */
	public function setRallye(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->rallye = $rallye;
	}

	/**
	 * Getter for rallye
	 *
	 * @return Tx_Wpjr_Domain_Model_Rallye rallye
	 */
	public function getRallye() {
		return $this->rallye;
	}

	/**
	 * Setter for login
	 *
	 * @param string $login login
	 * @return void
	 */
	public function setLogin($login) {
		$this->login = $login;
	}

	/**
	 * Getter for login
	 *
	 * @return string login
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * Setter for groupname
	 *
	 * @param string $groupname groupname
	 * @return void
	 */
	public function setGroupname($groupname) {
		$this->groupname = $groupname;
	}

	/**
	 * Getter for groupname
	 *
	 * @return string groupname
	 */
	public function getGroupname() {
		return $this->groupname;
	}
	
	
	
	public function importTask($taskJson){
		// create task
		$taskRepository = t3lib_div::makeInstance('Tx_Wpjr_Domain_Repository_TaskRepository');
		$task = $taskRepository->findByUid($taskJson->task);
		if ($task) {
			$this->task = $task;
			$this->rallye = $task->getRallye();
			$this->timestamp = $taskJson->timestamp;
			
			$content = array();
			$content['resultType'] = $task->getResulttype();
			
			// resulttype
			switch ($task->getResulttype()){
				case 'userphoto':	
				case 'photo': 
					// import photo
					$imgVar = $taskJson->content->photo;
					$tmpFile = $_FILES[$imgVar]['tmp_name'];
					if (!empty($tmpFile)) {
						$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
						$photo = $imageProcessor->getResizedBase64($tmpFile , 1024, 768, 90, "png");
						$content['photo'] = $photo;
						
					}else {
						$content['error'] = 'content->photo is empty: '.serialize($taskJson);
						$content['files'] = serialize($_FILES[$imgVar]);
					}
					
					break;
					
				case 'text':	
				default: $content['content'] = ($taskJson->content->text);break;
			}
			$this->content = json_encode($content, JSON_FORCE_OBJECT);
		}
			
		return $this->content;
	}
}
?>