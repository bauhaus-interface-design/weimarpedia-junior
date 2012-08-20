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
 * Result
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Domain_Model_ResultSet extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * tsBegin
	 * keep type as integer instead of DateTime - otherwise resultsets will not constructed from post reques
	 * 
	 * @var integer $tsBegin
	 */
	protected $tsBegin;

	/**
	 * tsEnd
	 * keep type as integer instead of DateTime - otherwise resultsets will not constructed from post request
	 *
	 * @var integer $tsEnd
	 */
	protected $tsEnd;

	/**
	 * rallye
	 *
	 * @var Tx_Wpjr_Domain_Model_Rallye $rallye
	 * 
	 */
	protected $rallye;

	/**
	 * meta
	 *
	 * @var array $meta
	 */
	protected $meta;

	/**
	 * The constructor.
	 * @param  $tsBegin
	 * @param  $tsEnd
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye
	 * 
	 * @return void
	 */
	public function __construct($tsBegin=NULL, $tsEnd=NULL, $rallye=NULL) {
		$this->tsBegin = $tsBegin;
		$this->tsEnd = $tsEnd;
		$this->rallye = $rallye;
		$this->meta = array();
		
	}


	/**
	 * 
	 * @return integer
	 */
	public function getTsBegin() {
		return $this->tsBegin;
	}
	/**
	 * 
	 * @return DateTime
	 */
	public function getDateBegin() {
		return "@".$this->tsBegin;
	}
	
	/**
	 * @param integer
	 * @return void
	 */
	public function setTsBegin($tsBegin) {
		$this->tsBegin = $tsBegin;
	}
	
	/**
	 * 
	 * @return integer
	 */
	public function getTsEnd() {
		return $this->tsEnd;
	}

	/**
	 * 
	 * @return DateTime
	 */
	public function getDateEnd() {
		return "@".$this->tsEnd;
	}
	
	/**
	 * @param integer
	 * @return void
	 */
	public function setTsEnd($tsEnd) {
		$this->tsEnd = $tsEnd;
	}

	/**
	 * 
	 * @return Tx_Wpjr_Domain_Model_Rallye
	 */
	public function getRallye() {
		return $this->rallye;
	}
	
	/**
	 * @param Tx_Wpjr_Domain_Model_Rallye
	 * @return void
	 */
	public function setRallye( Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->rallye = $rallye;
	}

	/**
	 * 
	 * @return integer
	 */
	public function getMeta() {
		return $this->meta;
	}
	
	/**
	 * @param integer
	 * @return void
	 */
	public function addMeta($key, $value) {
		$this->meta[$key] = $value;
	}
	
	
}
?>