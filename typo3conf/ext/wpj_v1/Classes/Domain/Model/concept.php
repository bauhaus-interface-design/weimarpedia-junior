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
 * concept
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_WpjV1_Domain_Model_concept extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * caption
	 * @var string
	 * @validate NotEmpty
	 */
	protected $caption;
	
	/**
	 * article_type
	 * @var Tx_WpjV1_Domain_Model_articletype
	 */
	protected $article_type;
	
	
	
	/**
	 * Setter for caption
	 *
	 * @param string $caption caption
	 * @return void
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}

	/**
	 * Getter for caption
	 *
	 * @return string caption
	 */
	public function getCaption() {
		return $this->caption;
	}
	
	/**
	 * Setter for article_type
	 *
	 * @param Tx_WpjV1_Domain_Model_articletype $article_type article_type
	 * @return void
	 */
	public function setArticle_type(Tx_WpjV1_Domain_Model_articletype $article_type) {
		$this->article_type = $article_type;
	}

	/**
	 * Getter for article_type
	 *
	 * @return Tx_WpjV1_Domain_Model_articletype article_type
	 */
	public function getArticle_type() {
		return $this->article_type;
	}
	
	/**
	 * Returns the caption as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getCaption();
	}
}
?>