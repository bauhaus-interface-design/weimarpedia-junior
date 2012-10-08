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
 * articletype
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_articletype extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * public
     * only public types can be manually assigned
     * some types are for internal use only
     * 
	 * @var boolean
	 */
	protected $public;
	
	/**
	 * taxonomies
     * some taxonomies belongs to a specific articletype
     * e.g. type: person -> taxonomy: born on 
     * 
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_taxonomy>
	 */
	protected $taxonomies;
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->taxonomies = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Setter for public
	 *
	 * @param boolean $public public
	 * @return void
	 */
	public function setPublic($public) {
		$this->public = $public;
	}

	/**
	 * Getter for public
	 *
	 * @return boolean public
	 */
	public function getPublic() {
		return $this->public;
	}
	
	/**
	 * Returns the boolean state of public
	 *
	 * @return bool The state of public
	 */
	public function isPublic() {
		$this->getPublic();
	}
	
	/**
	 * Setter for taxonomies
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_taxonomie> $taxonomies taxonomies
	 * @return void
	 */
	public function setTaxonomies(Tx_Extbase_Persistence_ObjectStorage $taxonomies) {
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Getter for taxonomies
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_taxonomie> taxonomies
	 */
	public function getTaxonomies() {
		return $this->taxonomies;
	}
	
	/**
	 * Adds a Taxonomie
	 *
	 * @param Tx_Wpj_Domain_Model_taxonomie The Taxonomie to be added
	 * @return void
	 */
	public function addTaxonomy(Tx_Wpj_Domain_Model_taxonomie $taxonomy) {
		$this->taxonomies->attach($taxonomy);
	}
	
	/**
	 * Removes a Taxonomie
	 *
	 * @param Tx_Wpj_Domain_Model_taxonomie The Taxonomie to be removed
	 * @return void
	 */
	public function removeTaxonomy(Tx_Wpj_Domain_Model_taxonomie $taxonomy) {
		$this->taxonomies->detach($taxonomy);
	}
	
}
?>