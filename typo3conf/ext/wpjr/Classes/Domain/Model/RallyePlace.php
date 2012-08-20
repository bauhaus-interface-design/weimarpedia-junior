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
 * RallyePlace
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Domain_Model_RallyePlace extends Tx_Extbase_DomainObject_AbstractEntity {

	
	/**
	 * @var integer
	 */
	protected $IMG_WIDTH = 600;
	
	/**
	 * @var integer
	 */
	protected $IMG_HEIGHT = 450;
	
	/**
	 * @var integer
	 */
	protected $IMG_QUALITY = 70;
	
	
	/**
	 * name
	 *
	 * @var string $name
	 * @validate NotEmpty
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
	 * image
	 *
	 * @var string $image
	 * @json
	 */
	protected $image;

	/**
	 * address
	 *
	 * @var string $address
	 */
	protected $address;

	/**
	 * lat
	 *
	 * @var float $lat
	 * @json
	 */
	protected $lat;

	/**
	 * lng
	 *
	 * @var float $lng
	 * @json
	 */
	protected $lng;

	/**
	 * accuracy
	 *
	 * @var string $accuracy
	 * @json
	 */
	protected $accuracy;

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
	 * Setter for image
	 *
	 * @param string $image image
	 * @return void
	 */
	public function setImage($image) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image", "rallyePlace", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
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
	 * Setter for address
	 *
	 * @param string $address address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Getter for address
	 *
	 * @return string address
	 */
	public function getAddress() {
		return $this->address;
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
	 * Setter for accuracy
	 *
	 * @param string $accuracy accuracy
	 * @return void
	 */
	public function setAccuracy($accuracy) {
		$this->accuracy = $accuracy;
	}

	/**
	 * Getter for accuracy
	 *
	 * @return string accuracy
	 */
	public function getAccuracy() {
		return $this->accuracy;
	}

}
?>