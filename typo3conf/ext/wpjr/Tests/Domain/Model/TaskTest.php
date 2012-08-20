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
 * Testcase for class Tx_Wpjr_Domain_Model_Task.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage WPJ Rallye
 * 
 */
class Tx_Wpjr_Domain_Model_TaskTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @var Tx_Wpjr_Domain_Model_Task
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Wpjr_Domain_Model_Task();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getParentReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 */
	public function setParentForIntegerSetsParent() { 
		$this->fixture->setParent(12);

		$this->assertSame(
			12,
			$this->fixture->getParent()
		);
	}
	
	/**
	 * @test
	 */
	public function getSortingReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getSorting()
		);
	}

	/**
	 * @test
	 */
	public function setSortingForIntegerSetsSorting() { 
		$this->fixture->setSorting(12);

		$this->assertSame(
			12,
			$this->fixture->getSorting()
		);
	}
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getIntroReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setIntroForStringSetsIntro() { 
		$this->fixture->setIntro('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getIntro()
		);
	}
	
	/**
	 * @test
	 */
	public function getInstructionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setInstructionForStringSetsInstruction() { 
		$this->fixture->setInstruction('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getInstruction()
		);
	}
	
	/**
	 * @test
	 */
	public function getImage1ReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImage1ForStringSetsImage1() { 
		$this->fixture->setImage1('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage1()
		);
	}
	
	/**
	 * @test
	 */
	public function getImage2ReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImage2ForStringSetsImage2() { 
		$this->fixture->setImage2('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage2()
		);
	}
	
	/**
	 * @test
	 */
	public function getImage3ReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImage3ForStringSetsImage3() { 
		$this->fixture->setImage3('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage3()
		);
	}
	
	/**
	 * @test
	 */
	public function getImage4ReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImage4ForStringSetsImage4() { 
		$this->fixture->setImage4('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage4()
		);
	}
	
	/**
	 * @test
	 */
	public function getDurationReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getDuration()
		);
	}

	/**
	 * @test
	 */
	public function setDurationForIntegerSetsDuration() { 
		$this->fixture->setDuration(12);

		$this->assertSame(
			12,
			$this->fixture->getDuration()
		);
	}
	
	/**
	 * @test
	 */
	public function getResulttypeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setResulttypeForStringSetsResulttype() { 
		$this->fixture->setResulttype('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getResulttype()
		);
	}
	
	/**
	 * @test
	 */
	public function getResultoptionsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setResultoptionsForStringSetsResultoptions() { 
		$this->fixture->setResultoptions('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getResultoptions()
		);
	}
	
	/**
	 * @test
	 */
	public function getResultrequiredReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getResultrequired()
		);
	}

	/**
	 * @test
	 */
	public function setResultrequiredForIntegerSetsResultrequired() { 
		$this->fixture->setResultrequired(12);

		$this->assertSame(
			12,
			$this->fixture->getResultrequired()
		);
	}
	
	/**
	 * @test
	 */
	public function getRallyeReturnsInitialValueForObjectStorageContainingTx_Wpjr_Domain_Model_Rallye() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRallye()
		);
	}

	/**
	 * @test
	 */
	public function setRallyeForObjectStorageContainingTx_Wpjr_Domain_Model_RallyeSetsRallye() { 
		$rallye = new Tx_Wpjr_Domain_Model_Rallye();
		$objectStorageHoldingExactlyOneRallye = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRallye->attach($rallye);
		$this->fixture->setRallye($objectStorageHoldingExactlyOneRallye);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRallye,
			$this->fixture->getRallye()
		);
	}
	
	/**
	 * @test
	 */
	public function addRallyeToObjectStorageHoldingRallye() {
		$rallye = new Tx_Wpjr_Domain_Model_Rallye();
		$objectStorageHoldingExactlyOneRallye = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRallye->attach($rallye);
		$this->fixture->addRallye($rallye);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRallye,
			$this->fixture->getRallye()
		);
	}

	/**
	 * @test
	 */
	public function removeRallyeFromObjectStorageHoldingRallye() {
		$rallye = new Tx_Wpjr_Domain_Model_Rallye();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($rallye);
		$localObjectStorage->detach($rallye);
		$this->fixture->addRallye($rallye);
		$this->fixture->removeRallye($rallye);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getRallye()
		);
	}
	
	/**
	 * @test
	 */
	public function getPlaceReturnsInitialValueForObjectStorageContainingTx_Wpjr_Domain_Model_RallyePlace() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPlace()
		);
	}

	/**
	 * @test
	 */
	public function setPlaceForObjectStorageContainingTx_Wpjr_Domain_Model_RallyePlaceSetsPlace() { 
		$place = new Tx_Wpjr_Domain_Model_RallyePlace();
		$objectStorageHoldingExactlyOnePlace = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePlace->attach($place);
		$this->fixture->setPlace($objectStorageHoldingExactlyOnePlace);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePlace,
			$this->fixture->getPlace()
		);
	}
	
	/**
	 * @test
	 */
	public function addPlaceToObjectStorageHoldingPlace() {
		$place = new Tx_Wpjr_Domain_Model_RallyePlace();
		$objectStorageHoldingExactlyOnePlace = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePlace->attach($place);
		$this->fixture->addPlace($place);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePlace,
			$this->fixture->getPlace()
		);
	}

	/**
	 * @test
	 */
	public function removePlaceFromObjectStorageHoldingPlace() {
		$place = new Tx_Wpjr_Domain_Model_RallyePlace();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($place);
		$localObjectStorage->detach($place);
		$this->fixture->addPlace($place);
		$this->fixture->removePlace($place);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPlace()
		);
	}
	
}
?>