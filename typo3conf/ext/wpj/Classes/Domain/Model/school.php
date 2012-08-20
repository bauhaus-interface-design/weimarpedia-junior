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
 * school
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_school extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * city
	 * @var string
	 */
	protected $city;
	
	/**
	 * state
	 * @var string
	 */
	protected $state;
	
	/**
	 * country
	 * @var string
	 */
	protected $country;
	
	/**
	 * url
	 * @var string
	 */
	protected $url;
	
	/**
	 * schooltype
	 * @var Tx_Wpj_Domain_Model_schooltype
	 */
	protected $schooltype;
	
	/**
	 * profile_article
	 * @var Tx_Wpj_Domain_Model_article
	 */
	protected $profile_article;
	
	
	
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
	 * Setter for city
	 *
	 * @param string $city city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Getter for city
	 *
	 * @return string city
	 */
	public function getCity() {
		return $this->city;
	}
	
	/**
	 * Setter for state
	 *
	 * @param string $state state
	 * @return void
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * Getter for state
	 *
	 * @return string state
	 */
	public function getState() {
		return $this->state;
	}
	
	/**
	 * Setter for country
	 *
	 * @param string $country country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Getter for country
	 *
	 * @return string country
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * Setter for url
	 *
	 * @param string $url url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Getter for url
	 *
	 * @return string url
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 * Setter for type
	 *
	 * @param Tx_Wpj_Domain_Model_schooltype $schooltype
	 * @return void
	 */
	public function setSchooltype(Tx_Wpj_Domain_Model_schooltype $schooltype) {
		$this->schooltype = $schooltype;
	}
	public function createSchooltype($name) {
		$this->schooltype = new Tx_Wpj_Domain_Model_schooltype($name);
	}
	
	/**
	 * Getter for type
	 *
	 * @return Tx_Wpj_Domain_Model_schooltype type
	 */
	public function getSchooltype() {
		return $this->schooltype;
	}
	
	/**
	 * Setter for profile_article
	 *
	 * @param Tx_Wpj_Domain_Model_article $profile_article profile_article
	 * @return void
	 */
	public function setProfile_article(Tx_Wpj_Domain_Model_article $profile_article) {
		$this->profile_article = $profile_article;
	}

	/**
	 * Getter for profile_article
	 *
	 * @return Tx_Wpj_Domain_Model_article profile_article
	 */
	public function getProfile_article() {
		return $this->profile_article;
	}
	
}
?>