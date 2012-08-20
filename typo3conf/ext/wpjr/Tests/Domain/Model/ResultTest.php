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
 * Testcase for class Tx_Wpjr_Domain_Model_Result.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage WPJ Rallye
 * 
 */
class Tx_Wpjr_Domain_Model_ResultTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @var Tx_Wpjr_Domain_Model_Result
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Wpjr_Domain_Model_Result();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getUserReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getUser()
		);
	}

	/**
	 * @test
	 */
	public function setUserForIntegerSetsUser() { 
		$this->fixture->setUser(12);

		$this->assertSame(
			12,
			$this->fixture->getUser()
		);
	}
	
	/**
	 * @test
	 */
	public function getContentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setContentForStringSetsContent() { 
		$this->fixture->setContent('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getContent()
		);
	}
	
	/**
	 * @test
	 */
	public function getTimestampReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getTimestamp()
		);
	}

	/**
	 * @test
	 */
	public function setTimestampForIntegerSetsTimestamp() { 
		$this->fixture->setTimestamp(12);

		$this->assertSame(
			12,
			$this->fixture->getTimestamp()
		);
	}
	
	/**
	 * @test
	 */
	public function getTaskReturnsInitialValueForObjectStorageContainingTx_Wpjr_Domain_Model_Task() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getTask()
		);
	}

	/**
	 * @test
	 */
	public function setTaskForObjectStorageContainingTx_Wpjr_Domain_Model_TaskSetsTask() { 
		$task = new Tx_Wpjr_Domain_Model_Task();
		$objectStorageHoldingExactlyOneTask = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneTask->attach($task);
		$this->fixture->setTask($objectStorageHoldingExactlyOneTask);

		$this->assertSame(
			$objectStorageHoldingExactlyOneTask,
			$this->fixture->getTask()
		);
	}
	
	/**
	 * @test
	 */
	public function addTaskToObjectStorageHoldingTask() {
		$task = new Tx_Wpjr_Domain_Model_Task();
		$objectStorageHoldingExactlyOneTask = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneTask->attach($task);
		$this->fixture->addTask($task);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneTask,
			$this->fixture->getTask()
		);
	}

	/**
	 * @test
	 */
	public function removeTaskFromObjectStorageHoldingTask() {
		$task = new Tx_Wpjr_Domain_Model_Task();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($task);
		$localObjectStorage->detach($task);
		$this->fixture->addTask($task);
		$this->fixture->removeTask($task);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getTask()
		);
	}
	
}
?>