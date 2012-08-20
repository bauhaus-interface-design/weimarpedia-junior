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
 * media
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_WpjV1_Domain_Model_media extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * content_type
	 * @var string
	 */
	protected $content_type;
	
	/**
	 * file
	 * @var string
	 * @validate NotEmpty
	 */
	protected $file;
	
	
	
	/**
	 * Setter for content_type
	 *
	 * @param string $content_type content_type
	 * @return void
	 */
	public function setContent_type($content_type) {
		$this->content_type = $content_type;
	}

	/**
	 * Getter for content_type
	 *
	 * @return string content_type
	 */
	public function getContent_type() {
		return $this->content_type;
	}
	
	/**
	 * Setter for file
	 *
	 * @param string $file file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * Getter for file
	 *
	 * @return string file
	 */
	public function getFile() {
		return $this->file;
	}
	
}
?>