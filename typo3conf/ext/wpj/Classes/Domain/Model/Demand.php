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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *  Demand contains all settings for a search query
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
	 * Sets the scope
     * 
     * @param string $scope
	 * @return void
	 */
	public function setScope($scope = NULL) {
		$this->scope = $scope;
	}
	
	/**
	 * Returns the scope
     * 
	 * @return string
	 */
	public function getScope() {
		return $this->scope;
	}

	/**
     * Sets the searchterm
     * 
	 * @param string $searchterm
	 */
	public function setSearchterm($searchterm) {
		$this->searchterm = trim($searchterm);
	}

	/**
	 * Returns the searchterm
     * 
	 * @return string searchterm
	 */
	public function getSearchterm() {
		return trim($this->searchterm);
	}
		
	/**
     * Returns the length of the searchterm
	 *  
	 * @return integer
	 */
	public function getSearchtermLength() {
		return strlen($this->getSearchterm());
	}
    
    /**
     * Sets the results limit 
     * 
     * @param integer $limit
     */
    public function setLimit($limit) {
        $this->limit = $limit;
    }
	
	/**
	 * Returns the results limit 
     * 
	 * @return integer $limit
	 */
	public function getLimit() {
		return $this->limit;
	}
	
	
	/**
     * Returns the scope humand readable
     *
	 * @param string
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
	 * Returns true if searching in scope "authors"
	 * @return boolean
	 */
	public function getIsAuthorScope() {
		return ($this->scope == 'authors');
	}
	
	
}
?>