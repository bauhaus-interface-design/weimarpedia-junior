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
 * article
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_WpjV1_Domain_Model_article extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * article_type
	 * @var string
	 * @validate NotEmpty
	 */
	protected $article_type;
	
	/**
	 * title
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	/**
	 * body
	 * @var string
	 */
	protected $body;
	
	/**
	 * places
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_places>
	 */
	protected $places;
	
	/**
	 * tags
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_tag>
	 */
	protected $tags;
	
	/**
	 * medias
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_media>
	 */
	protected $medias;
	
	/**
	 * type
	 * @var Tx_WpjV1_Domain_Model_articletype
	 */
	protected $type;
	
	
	
	/**
	 * tstamp
	 * @var integer
	 */
	protected $tstamp;
	
	
	/**
	 * Setter for 
	 *
	 * @param integer 
	 * @return void
	 */
	public function setTstamp($tstamp) {
		$this->tstamp = $tstamp;
	}

	/**
	 * Getter for 
	 *
	 * @return string 
	 */
	public function getTstamp() {
		return $this->tstamp;
	}
	
	public function getLastModified() {
		return date("m.d.y", $this->tstamp);
	}
	
	
	/**
	 * Setter for article_type
	 *
	 * @param string $article_type article_type
	 * @return void
	 */
	public function setArticle_type($article_type) {
		$this->article_type = $article_type;
	}

	/**
	 * Getter for article_type
	 *
	 * @return string article_type
	 */
	public function getArticle_type() {
		return $this->article_type;
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
	 * Setter for body
	 *
	 * @param string $body body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * Getter for body
	 *
	 * @return string body
	 */
	public function getBody() {
		return $this->body;
	}
	
	public function getRawBody() {
		return html_entity_decode( strip_tags($this->body) );
	}
	
	/**
	 * Setter for places
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_places> $places places
	 * @return void
	 */
	public function setPlaces(Tx_Extbase_Persistence_ObjectStorage $places) {
		$this->places = $places;
	}

	/**
	 * Getter for places
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_places> places
	 */
	public function getPlaces() {
		return $this->places;
	}
	
	/**
	 * Adds a Places
	 *
	 * @param Tx_WpjV1_Domain_Model_places The Places to be added
	 * @return void
	 */
	public function addPlace(Tx_WpjV1_Domain_Model_places $place) {
		$this->places->attach($place);
	}
	
	/**
	 * Removes a Places
	 *
	 * @param Tx_WpjV1_Domain_Model_places The Places to be removed
	 * @return void
	 */
	public function removePlace(Tx_WpjV1_Domain_Model_places $place) {
		$this->places->detach($place);
	}
	
	/**
	 * Setter for tags
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_tag> $tags tags
	 * @return void
	 */
	public function setTags(Tx_Extbase_Persistence_ObjectStorage $tags) {
		$this->tags = $tags;
	}

	/**
	 * Getter for tags
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_tag> tags
	 */
	public function getTags() {
		return $this->tags;
	}
	
	/**
	 * Adds a Tag
	 *
	 * @param Tx_WpjV1_Domain_Model_tag The Tag to be added
	 * @return void
	 */
	public function addTag(Tx_WpjV1_Domain_Model_tag $tag) {
		$this->tags->attach($tag);
	}
	
	/**
	 * Removes a Tag
	 *
	 * @param Tx_WpjV1_Domain_Model_tag The Tag to be removed
	 * @return void
	 */
	public function removeTag(Tx_WpjV1_Domain_Model_tag $tag) {
		$this->tags->detach($tag);
	}
	
	/**
	 * Setter for medias
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_media> $medias medias
	 * @return void
	 */
	public function setMedias(Tx_Extbase_Persistence_ObjectStorage $medias) {
		$this->medias = $medias;
	}

	/**
	 * Getter for medias
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WpjV1_Domain_Model_media> medias
	 */
	public function getMedias() {
		return $this->medias;
	}
	
	/**
	 * Adds a Media
	 *
	 * @param Tx_WpjV1_Domain_Model_media The Media to be added
	 * @return void
	 */
	public function addMedia(Tx_WpjV1_Domain_Model_media $media) {
		$this->medias->attach($media);
	}
	
	/**
	 * Removes a Media
	 *
	 * @param Tx_WpjV1_Domain_Model_media The Media to be removed
	 * @return void
	 */
	public function removeMedia(Tx_WpjV1_Domain_Model_media $media) {
		$this->medias->detach($media);
	}
	
	/**
	 * Setter for type
	 *
	 * @param Tx_WpjV1_Domain_Model_articletype $type type
	 * @return void
	 */
	public function setType(Tx_WpjV1_Domain_Model_articletype $type) {
		$this->type = $type;
	}

	/**
	 * Getter for type
	 *
	 * @return Tx_WpjV1_Domain_Model_articletype type
	 */
	public function getType() {
		return $this->type;
	}
	
}
?>