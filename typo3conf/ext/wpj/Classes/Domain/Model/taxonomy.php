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
 * taxonomy
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_taxonomy extends Tx_Extbase_DomainObject_AbstractValueObject {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * articletype
	 * @var Tx_Wpj_Domain_Model_articletype
	 */
	protected $articletype;
	
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
		return $this->name." ";
	}
	
	/**
	 * Getter for name
	 *
	 * @return string name
	 */
	public function getIcon() {
		return "(".$this->getUid().")";
	}
	
	/**
	 * Setter for articletype
	 *
	 * @param Tx_Wpj_Domain_Model_articletype $articletype articletype
	 * @return void
	 */
	public function setArticletype(Tx_Wpj_Domain_Model_articletype $articletype) {
		$this->articletype = $articletype;
	}

	/**
	 * Getter for articletype
	 *
	 * @return Tx_Wpj_Domain_Model_articletype articletype
	 */
	public function getArticletype() {
		return $this->articletype;
	}
}
?>