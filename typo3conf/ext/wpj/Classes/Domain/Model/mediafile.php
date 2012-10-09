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
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * mediafile 
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_mediafile extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * title for interal use
     * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	/**
	 * file
	 * @var string
	 */
	protected $file;
	
	/**
	 * copyright
	 * @var string
	 */
	protected $copyright;
	
	/**
	 * contentType
	 * @var string
	 */
	protected $contentType;
	
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
		
	
	
	protected $UPLOAD_DIR = 'uploads/wpj/mediafiles';
	
	/**
	 * Constructs this mediafile
	 */
	public function __construct($file, $title='') {
		$this->setFile($file);
		$this->setTitle($title);
	}	
	
	/**
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Setter for file
	 *
	 * @param string $file file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = basename($file);
	}

	/**
	 * Getter for file
	 *
	 * @return string file
	 */
	public function getFile() {
		return $this->file;
	}
	
	/**
	 * Setter for copyright
	 *
	 * @param string $copyright copyright
	 * @return void
	 */
	public function setCopyright($copyright) {
		$this->copyright = $copyright;
	}

	/**
	 * Getter for copyright
	 *
	 * @return string copyright
	 */
	public function getCopyright() {
		return $this->copyright;
	}
	
	/**
	 * Setter for contentType
	 *
	 * @param string $contentType contentType
	 * @return void
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}

	/**
	 * Getter for content_type
	 *
	 * @return string content_type
	 */
	public function getContentType() {
		return $this->contentType;
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
     * Returns url uploads/...
     *
     * @return string 
     */
	public function getUrl() {
		return $this->UPLOAD_DIR."/".basename( $this->file );
	}
	
    /**
     * Returns config string for video player 
     *
     * @return string 
     */
	public function getVideoFlashvars() {
		$baseUri = "http://".t3lib_div::getThisUrl();
		// TODO: find solution for escaping curly brackets in fluid
		return 'config={"playlist":["'.$baseUri.'typo3conf/ext/wpj/Resources/Public/img/weimarpedia_button.png", {"url": "'.$baseUri.$this->getUrl().'","autoPlay":false,"autoBuffering":true}]}';
	}
	
    /**
     * Returns true if media is a video
     *
     * @return string 
     */
	public function getIsVideo(){
		return strpos($this->getContentType(), 'video') !== false;
	}

    /**
     * Returns true if media is an image
     *
     * @return string 
     */
	public function getIsImage(){
		return strpos($this->getContentType(), 'image') !== false;
	}
	
    /**
     * Returns true if media is an audiofile
     *
     * @return string 
     */
	public function getIsAudio(){
		return strpos($this->getContentType(), 'audio') !== false;
	}

    /**
     * Returns true if media is an pdf
     *
     * @return string 
     */
	public function getIsPdf(){
		$ext = strtolower(array_pop(explode('.',$this->file)));
		return ($ext == "pdf");
	}
	
    /**
     * Returns the preview-url for the mediafile
     * images: url
     * audio/video: icon
     *
     * @return string 
     */
	public function getPreviewUrl(){
		if ($this->getIsVideo()) return "icon_video.png";
		else if ($this->getIsAudio()) return "icon_audio.png";
		return $this->getUrl();
	}
}
?>