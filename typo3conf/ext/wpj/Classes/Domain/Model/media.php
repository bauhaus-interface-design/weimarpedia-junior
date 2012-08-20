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
class Tx_Wpj_Domain_Model_media extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	/**
	 * reviewed
	 * @var integer
	 */
	protected $reviewed;
	
	/**
	 * position
	 * @var integer
	 */
	protected $position;
	
	/**
	 * mediafile
	 * @var Tx_Wpj_Domain_Model_mediafile
	 */
	protected $mediafile;
	
	/**
	 * Constructs this media
	 */
//	public function __construct(Tx_Wpj_Domain_Model_mediafile $mediafile) {
//		$this->setMediafile($mediafile);
//	}	
	
	
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
		$description = ($this->description) ? $this->description : $this->mediafile->getDescription();
		return ($description) ? $description : "Bildunterschrift bitte erg&auml;nzen";
	}
	
	/**
	 * Setter for reviewed
	 *
	 * @param integer $reviewed reviewed
	 * @return void
	 */
	public function setReviewed($reviewed) {
		$this->reviewed = $reviewed;
	}

	/**
	 * Getter for reviewed
	 *
	 * @return integer reviewed
	 */
	public function getReviewed() {
		return $this->reviewed;
	}
	
	/**
	 * Setter for position
	 *
	 * @param integer $position position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * Getter for position
	 *
	 * @return integer position
	 */
	public function getPosition() {
		return $this->position;
	}
	
	/**
	 * Setter for media
	 *
	 * @param Tx_Wpj_Domain_Model_mediafile $media media
	 * @return void
	 */
	public function setMediafile(Tx_Wpj_Domain_Model_mediafile $mediafile) {
		$this->mediafile = $mediafile;
	}

	/**
	 * Getter for media
	 *
	 * @return Tx_Wpj_Domain_Model_mediafile media
	 */
	public function getMediafile() {
		return $this->mediafile;
	}
	
	public function getUrl(){
		if (!$this->mediafile) return false;
		return $this->mediafile->getUrl();
	}
	public function getContentType(){
		if (!$this->mediafile) return false;
		return $this->mediafile->getContentType();
	}
	public function getPreviewUrl(){
		return $this->mediafile->getPreviewUrl();
	}
	
	public function getIsVideo(){
		return $this->mediafile->getIsVideo();
	}
	public function getIsImage(){
		return $this->mediafile->getIsImage();
	}
	public function getIsAudio(){
		return $this->mediafile->getIsAudio();
	}
	public function getIsPdf(){
		return $this->mediafile->getIsPdf();
	}
}
?>