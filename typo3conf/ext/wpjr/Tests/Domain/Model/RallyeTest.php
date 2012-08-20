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
 * Testcase for class Tx_Wpjr_Domain_Model_Rallye.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage WPJ Rallye
 * 
 */
class Tx_Wpjr_Domain_Model_RallyeTest extends Tx_Extbase_BaseTestCase {
	/**
	 * @var Tx_Wpjr_Domain_Model_Rallye
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Wpjr_Domain_Model_Rallye();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getCommentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCommentForStringSetsComment() { 
		$this->fixture->setComment('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getComment()
		);
	}
	
	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImageForStringSetsImage() { 
		$this->fixture->setImage('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage()
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
	public function getAuthorReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAuthor()
		);
	}

	/**
	 * @test
	 */
	public function setAuthorForIntegerSetsAuthor() { 
		$this->fixture->setAuthor(12);

		$this->assertSame(
			12,
			$this->fixture->getAuthor()
		);
	}
	
}
?>