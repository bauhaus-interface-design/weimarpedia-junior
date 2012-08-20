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
 * place
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_place extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * lat
	 * @var float
	 */
	protected $lat;
	
	/**
	 * lng
	 * @var float
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
	 * accuracy
	 * @var int
	 */
	protected $accuracy;

	/**
	 * Image
	 *@var string
	 */
	protected $image;
	
	/**
	 * Icon
	 *@var string
	 */
	protected $icon;
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	/**
	 * parent
	 * @var Tx_Wpj_Domain_Model_place
	 * @lazy
	 */
	protected $parent;
	
	/**
	 * accuracyLabel
	 * @var array
	 */
	private $accuracyLabels = array(
		"",
		"",
		"Kontinent", // 2
		"Land",
		"Bundesland",
		"Ort",
		"Strasse",	// 6
		"Haus",
		"Stockwerk",
		"Raum",		// 9
		"Objekt",
		);
	
	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
		$this->accuracy = count( $this->pathToRoot($this) );	
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
	 * @param float $lng lng
	 * @return void
	 */
	public function setLng($lng) {
		$this->lng = $lng;
	}

	/**
	 * Getter for lng
	 *
	 * @return float lng
	 */
	public function getLng() {
		return $this->lng;
	}
	
	/**
	 * Getter for lng
	 *
	 * @return float lng
	 */
	public function getHasPosition() {
		return ($this->lng != '' && $this->lat != '') ? 1:0;
	}
	
	
	/**
	 * Setter for image
	 *
	 * @param string $image image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
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
	 * Setter for icon
	 *
	 * @param string $icon icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Getter for icon
	 *
	 * @return string icon
	 */
	public function getIcon() {
		return $this->icon;
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
	
	/**
	 * Setter for accuracy
	 *
	 * @param string $accuracy accuracy
	 * @return void
	 */
	public function setAccuracy($accuracy) {
		//$this->accuracy = $accuracy;
	}

	/**
	 * Getter for accuracy
	 *
	 * @return int accuracy
	 */
	public function getAccuracy() {
		return $this->accuracy;
	}
	
	/**
	 * Getter for accuracyLabel
	 *
	 * @return string accuracyLabel
	 */
	public function getAccuracyLabel() {
		return $this->accuracyLabels[ $this->accuracy ];
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
	 * Setter for parent
	 *
	 * @param Tx_Wpj_Domain_Model_place $parent parent
	 * @return void
	 */
	public function setParent(Tx_Wpj_Domain_Model_place $parent) {
		$this->parent = $parent;
		$this->accuracy = count( $this->pathToRoot($this) );	
	}

	/**
	 * Getter for parent
	 *
	 * @return Tx_Wpj_Domain_Model_place parent
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * Returns all childs of this
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function getChildren() {
		$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_PlaceRepository');
		$children = $placeRepository->findAllChildren($this);
		return $children;
	}
	
	
	
	
	/**
	 * Returns path to root level
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function pathToRoot(Tx_Wpj_Domain_Model_Place $place) {
		// start with current place
		$path = array($place);
		
		// find parents
		$parent = $place->getParent();
		while ($parent) {
			array_push($path, $parent);
			$parent = $parent->getParent();
		}
		return array_reverse($path);
	}
	
		
	/**
	 * Returns 
	 * @return 
	 */
	public function getHasCoordinates(){
		return ($this->coordinates != '') ? 1:0;
	}
	
	
	public function getArticles(){
		$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_PlaceRepository');
		return $placeRepository->getArticlesOfPlace($this);
	}
	
	
}
?>