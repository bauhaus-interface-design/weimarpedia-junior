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
 * tag
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_tag extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * place
	 * @var Tx_Wpj_Domain_Model_place
	 */
	protected $place;
	
	/**
	 * taxonomy
	 * @var Tx_Wpj_Domain_Model_taxonomy
	 */
	protected $taxonomy;
	
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
	 * Setter for place
	 *
	 * @param Tx_Wpj_Domain_Model_place $place place
	 * @return void
	 */
	public function setPlace(Tx_Wpj_Domain_Model_place $place) {
		$this->place = $place;
	}

	/**
	 * Getter for place
	 *
	 * @return Tx_Wpj_Domain_Model_place place
	 */
	public function getPlace() {
		return $this->place;
	}
	
	/**
	 * Setter for taxonomy
	 *
	 * @param Tx_Wpj_Domain_Model_taxonomy $taxonomy taxonomy
	 * @return void
	 */
	public function setTaxonomy(Tx_Wpj_Domain_Model_taxonomy $taxonomy) {
		$this->taxonomy = $taxonomy;
	}

	/**
	 * Getter for taxonomy
	 *
	 * @return Tx_Wpj_Domain_Model_taxonomy taxonomy
	 */
	public function getTaxonomy() {
		return $this->taxonomy;
	}

	/**
	 * Returns this tag as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		$str = $this->name;
		$str .= " tax: ".$this->taxonomy->getName;
		if ($this->place) $str .= " : ".$this->place->getName;
		return $str;
	}	
	
	
	/**
	 * fix an encoding problem occuring, if a tag is created by an ajax request
	 * TODO fix this before creating tag instance
	 *
	 * @return void
	 */
	public function fixEncoding() {
		$this->name = utf8_decode($this->name);
	}
	
	
	/**
	 * Getter for taxonomyname
	 *
	 * @return String
	 */
	public function getTaxonomyName() {
		$taxonomy = $this->taxonomy;		
		return ($taxonomy) ? $taxonomy->getName()." " : '';
	}
	
	
	
	
}
?>