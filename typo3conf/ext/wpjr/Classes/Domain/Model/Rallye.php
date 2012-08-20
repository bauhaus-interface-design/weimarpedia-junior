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
 * Rallye
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Domain_Model_Rallye extends Tx_Extbase_DomainObject_AbstractEntity {

	
	/**
	 * @var integer
	 */
	protected $IMG_WIDTH = 600;
	
	/**
	 * @var integer
	 */
	protected $IMG_HEIGHT = 800;
	
	/**
	 * @var integer
	 */
	protected $IMG_QUALITY = 80;
	

	/**
	 * name
	 *
	 * @var string $name
	 * @validate NotEmpty
	 * @validate StringLength(maximum = 30)
	 * @json
	 */
	protected $name;
	
	/**
	 * description
	 *
	 * @var string $description
	 * @json
	 */
	protected $description;

	/**
	 * comment
	 * @var string $comment
	 */
	protected $comment;

	/**
	 * duration
	 * @var integer $duration
	 */
	protected $duration;

	/**
	 * author
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser $author
	 */
	protected $author;

	/**
	 * image
	 *
	 * @var string $image
	 * @json
	 */
	protected $image;

	/**
	 * tasks
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Wpjr_Domain_Model_Task> $tasks
	 * @lazy
	 * @cascade remove
	 */
	protected $tasks;
	
	/**
	 * active
	 *
	 * @var integer $active
	 */
	protected $active;
	
	
	
	/**
	 * active
	 *
	 * @var integer $presentation
	 * @json
	 */
	protected $presentation;
	
	
	/**
	 * The constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->tasks = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Getter for name
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Setter for description
	 *
	 * @param string $description description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Getter for description
	 *
	 * @return string description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Setter for comment
	 *
	 * @param string $comment comment
	 * @return void
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * Getter for comment
	 *
	 * @return string comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Setter for image
	 *
	 * @param string $image image
	 * @return void
	 */
	public function setImage($image) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image", "rallye", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
		if (!is_null($image)) $this->image = $image;
	}

	/**
	 * Getter for image
	 *
	 * @return string image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * 
	 */
	public function getImageLength() {
		return 5+strlen($this->image);
	}
	
	/**
	 * Setter for duration
	 *
	 * @param integer $duration duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}

	/**
	 * Getter for duration
	 *
	 * @return integer duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Setter for author
	 *
	 * @param integer $author author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Getter for author
	 *
	 * @return Tx_Extbase_Domain_Model_FrontendUser author
	 */
	public function getAuthor() {
		return $this->author;
	}

	

	/**
	 * Adds a task to this rallye
	 *
	 * @param Tx_Wpjr_Domain_Model_Task $task
	 * @return void
	 */
	public function addTask(Tx_Wpjr_Domain_Model_Task $task) {
		$this->tasks->attach($task);
	}

	/**
	 * Remove a task from this rallye
	 *
	 * @param Tx_Wpjr_Domain_Model_Task $taskToRemove The task to be removed
	 * @return void
	 */
	public function removeTask(Tx_Wpjr_Domain_Model_Task $taskToRemove) {
		$this->tasks->detach($taskToRemove);
	}

	/**
	 * Remove all tasks from this rallye
	 *
	 * @return void
	 */
	public function removeAllTasks() {
		$this->tasks = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns all tasks in this rallye
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getTasks() {
		return $this->tasks;
	}
	
	/**
	 * Setter for active
	 *
	 * @param string $active active
	 * @return void
	 */
	public function setActive($active) {
		$this->active = strval($active);
	}

	/**
	 * Getter for active
	 *
	 * @return integer
	 */
	public function getActive() {
		return $this->active;
	}

	public function getDisabled() {
		return ($this->active != 1);
	}
	
	
	
	
	/**
	 * Setter for presentation
	 *
	 * @param string $presentation presentation
	 * @return void
	 */
	public function setPresentation($presentation) {
		$this->presentation = strval($presentation);
		if ($this->presentation == 1 && count($this->tasks) == 0){
			// create tasks for input username and photo
			$this->addUserInfoTasks();
		}
		
	}

	/**
	 * 
	 * @return void
	 */
	private function addUserInfoTasks() {
		$task = new Tx_Wpjr_Domain_Model_Task();
		$task->setTitle("Los gehts mit eurem Foto");
		$task->setInstruction("Bitte zunächst ein Foto von eurer Gruppe machen.");
		$task->setResulttype(3); // photo
		$task->setResultrequired(true);
		$this->addTask($task);
		
		$task = new Tx_Wpjr_Domain_Model_Task();
		$task->setTitle("Und jetzt eure Namen");
		$task->setInstruction("Bitte gebt eure Namen ein.");
		$task->setResulttype(2); // text
		$task->setResultrequired(true);	
		$this->addTask($task);
	}
	

	/**
	 * Getter for presentation
	 *
	 * @return integer
	 */
	public function getPresentation() {
		return $this->presentation;
	}

	public function getHasPresentation() {
		return ($this->presentation == 1);
	}
	
	
	
}
?>