<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 
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
 * places
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_WpjV1_Domain_Model_places extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * parent_id
	 * @var string
	 * @validate NotEmpty
	 */
	protected $parent_id;
	
	/**
	 * label
	 * @var string
	 * @validate NotEmpty
	 */
	protected $tx_wpjv1_label;
	
	/**
	 * lat
	 * @var float
	 */
	protected $lat;
	
	/**
	 * lng
	 * @var string
	 */
	protected $lng;
	
	/**
	 * other objects e.g. lines
	 * @var string
	 */
	protected $coordinates;
	
	/**
	 * reviewed
	 * @var boolean
	 */
	protected $reviewed;
	
	
	
	/**
	 * Setter for parent_id
	 *
	 * @param string $parent_id parent_id
	 * @return void
	 */
	public function setParent_id($parent_id) {
		$this->parent_id = $parent_id;
	}

	/**
	 * Getter for parent_id
	 *
	 * @return string parent_id
	 */
	public function getParent_id() {
		return $this->parent_id;
	}
	
	/**
	 * Setter for label
	 *
	 * @param string $label label
	 * @return void
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Getter for label
	 *
	 * @return string label
	 */
	public function getLabel() {
		return $this->label;
	}
	
	/**
	 * Setter for lat
	 *
	 * @param float $lat lat
	 * @return void
	 */
	public function setLat($lat) {
		$this->lat = $lat;
	}

	/**
	 * Getter for lat
	 *
	 * @return float lat
	 */
	public function getLat() {
		return $this->lat;
	}
	
	/**
	 * Setter for lng
	 *
	 * @param string $lng lng
	 * @return void
	 */
	public function setLng($lng) {
		$this->lng = $lng;
	}

	/**
	 * Getter for lng
	 *
	 * @return string lng
	 */
	public function getLng() {
		return $this->lng;
	}
	
	/**
	 * Setter for coordinates
	 *
	 * @param string $coordinates other objects e.g. lines
	 * @return void
	 */
	public function setCoordinates($coordinates) {
		$this->coordinates = $coordinates;
	}

	/**
	 * Getter for coordinates
	 *
	 * @return string other objects e.g. lines
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}
	
	/**
	 * Setter for reviewed
	 *
	 * @param boolean $reviewed reviewed
	 * @return void
	 */
	public function setReviewed($reviewed) {
		$this->reviewed = $reviewed;
	}

	/**
	 * Getter for reviewed
	 *
	 * @return boolean reviewed
	 */
	public function getReviewed() {
		return $this->reviewed;
	}
	
	/**
	 * Returns the boolean state of reviewed
	 *
	 * @return bool The state of reviewed
	 */
	public function isReviewed() {
		$this->getReviewed();
	}
	
}
?>