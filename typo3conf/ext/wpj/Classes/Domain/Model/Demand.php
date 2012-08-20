<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * 
 */
class Tx_Wpj_Domain_Model_Demand extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * @var integer
	 **/
	protected $articletype;
	
	/**
	 * @var string
	 **/
	protected $searchterm;
	/**
	 * @var string
	 **/
	protected $scope; 
		
	/**
	 * @var integer
	 **/
	protected $limit = 40;
	
	
	/**
	 * @param string $scope
	 * @return void
	 */
	public function setScope($scope = NULL) {
		$this->scope = $scope;
	}
	
	/**
	 * @param 
	 * @return void
	 */
	public function getScope() {
		return $this->scope;
	}

	/**
	 * @param string $searchterm
	 * @return void
	 */
	public function setSearchterm($searchterm) {
		$this->searchterm = trim($searchterm);
	}

	/**
	 * @param 
	 * @return void
	 */
	public function getSearchterm() {
		return trim($this->searchterm);
	}
		
	/**
	 * @param 
	 * @return integer
	 */
	public function getSearchtermLength() {
		return strlen($this->getSearchterm());
	}
	
	/**
	 * @param 
	 * @return void
	 */
	public function getLimit() {
		return $this->limit;
	}
	
	/**
	 * @param 
	 * @return void
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}
	
	
	/**
	 * @param 
	 * @return string
	 */
	public function getScopeOutput() {
		switch ($this->scope){
			case 'knowledge': $output = 'im Lexikon';break;
			case 'gallery': $output = 'in der Galerie';break;
			case 'people': $output = 'in Personen aus dem Lexikon';break;
			case 'objects': $output = 'in Objekten aus dem Lexikon';break;
			case 'authors': $output = 'in Artikel-Autoren';break;
			default: $output = '';break;
		}
		return $output; 
	}
	
	
	/**
	 * @param 
	 * @return void
	 */
	public function getIsAuthorScope() {
		return ($this->scope == 'authors');
	}
	
	
}
?>