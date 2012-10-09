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
 * article
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_article extends Tx_Extbase_DomainObject_AbstractEntity {
	
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
	 * reviewed
	 * @var integer
	 */
	protected $reviewed;
		
	/**
	 * voting
     * voting is queried for article charts
     * 1 for charts over the last year
     * 2 for alltime favorit articles
     * 
	 * @var integer
	 */
	protected $voting;
	
	/**
	 * tstamp
	 * @var integer
	 */
	protected $tstamp;
	
	/**
	 * crdate
	 * @var integer
	 */
	protected $crdate;
	
	/**
	 * tags
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag>
	 * @lazy
	 */
	protected $tags;
	
	/**
	 * medias
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_media>
	 * @lazy
	 */
	protected $medias;
	
	/**
	 * articletype
	 * @var Tx_Wpj_Domain_Model_articletype
	 * 
	 */
	protected $articletype;
	
	/**
	 * authors
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_author>
	 */
	protected $authors;

	/**
	 * t3ver_id
     * for article versioning
	 * @var integer
	 */
	protected $t3ver_id;
    
	/**
	 * pid
     * for article versioning
	 * @var integer
	 */
	protected $pid;	
    
	/**
	 * t3ver_label
     * for article versioning
	 * @var string
	 */
	protected $t3ver_label;	
	
	
	
	/**
	 * Constructs this article with presets
	 */
	public function __construct() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		$this->authors = new Tx_Extbase_Persistence_ObjectStorage();
		$this->date = new DateTime();
		$this->reviewed = false;
		$this->title = "Name des Artikels";
		$this->body = utf8_decode( "Ein Artikel sollte mit einer kurzen Zusammenfassung starten und sich dann strukturiert den einzelnen Aspekten widmen.");
	}
	
	/**
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = trim(strip_tags($title));
	}

	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return trim($this->title);
	}
	
	/**
	 * Setter for body
	 *
	 * @param string $body body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = trim($body);
	}

	/**
	 * Getter for body
	 *
	 * @return string body
	 */
	public function getBody() {
		return (!empty($this->body)) ? $this->body : "Artikeltext..."; // aloha needs a piece of text
	}
	
	/**
	 * Setter for reviewed
	 *
	 * @param integer $reviewed reviewed
	 * @return void
	 */
	public function setReviewed($reviewed) {
		$this->reviewed = ($reviewed) ? time() : 0;
	}

	/**
	 * Getter for reviewed
	 *
	 * @return int reviewed
	 */
	public function getReviewed() {
		return ($this->reviewed);
	}
	
	/**
	 * Setter for voting
	 *
	 * @param integer $voting voting
	 * @return void
	 */
	public function setVoting($voting) {
		$this->voting = $voting;
	}

	/**
	 * Getter for voting
	 *
	 * @return boolean voting
	 */
	public function getVoting() {
		return ($this->voting);
	}
	
	/**
	 * Setter for tags
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag> $tags tags
	 * @return void
	 */
	public function setTags(Tx_Extbase_Persistence_ObjectStorage $tags) {
		$this->tags = $tags;
	}

	/**
	 * Getter for tags including tags / places / reference tags 
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag> tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Getter for tags of taxonomy reference
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag> tags
	 */
	public function getRefPlaceTag() {
		$tags = Tx_Wpj_Utility_Array::collectIf( $this->tags, "Taxonomy", 2); 
		return $tags;
	}
	
	/**
	 * Getter for tags without places
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag> tags
	 */
	public function getNonPlaceTags() {
		$tags = Tx_Wpj_Utility_Array::collectIf( $this->tags, "Place", 0);
		return $tags;
	}

	/**
	 * Getter for tags for places
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_tag> tags
	 */
	public function getPlaceTags() {
		$tags = Tx_Wpj_Utility_Array::collectIfNot( $this->tags, "Place", 0);
		$tags = Tx_Wpj_Utility_Array::collectIfNot( $tags, "Taxonomy", 2); // exclude reference-places
		return $tags;
	}
		
	/**
	 * Adds a Tag
	 *
	 * @param Tx_Wpj_Domain_Model_tag The Tag to be added
	 * @return void
	 */
	public function addTag(Tx_Wpj_Domain_Model_tag $tag) {
		$this->tags->attach($tag);
	}
	
	/**
	 * Removes a Tag
	 *
	 * @param Tx_Wpj_Domain_Model_tag The Tag to be removed
	 * @return void
	 */
	public function removeTag(Tx_Wpj_Domain_Model_tag $tag) {
		$this->tags->detach($tag);
	}
	
	/**
	 * Setter for medias
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_media> $medias medias
	 * @return void
	 */
	public function setMedias(Tx_Extbase_Persistence_ObjectStorage $medias) {
		$this->medias = $medias;
	}

	/**
	 * Setter for medias 
     * $mediaContent is a string {media_id}##{caption}\n created by js
     * e.g.: 666##Bildunterschrift\n
	 *
	 * @param String $mediaContent
	 * @return void
	 */
	public function setMediaContent($mediaContent) {
		$mediaRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_mediaRepository');
		$new_medias = explode("\n", $mediaContent);
		foreach ($new_medias as $new_media){
			list($uid, $text) = explode("##", $new_media);
			$uid = (integer)$uid;
			if ($uid != 0) {
				$media = $mediaRepository->findByUid($uid);
				$text = urldecode($text);
				$text = html_entity_decode($text);
				$media->setDescription($text);
			}
		}
	}
	
	/**
	 * Getter for medias
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_media> medias
	 */
	public function getMedias() {
		return $this->medias;
	}
	
	/**
	 * Getter for the article thumbnail
     * finds the first image or returns a placeholder
	 *
	 * @return String
	 */
	public function getThumbnailUrl() {
		// find first image
		foreach ($this->medias as $media){
			if ($media->getIsImage()) {
				$thumbnail = $media->getUrl();
				break;
			}
		}
		if (!$thumbnail){
			// if no image found: find a pdf-file
			foreach ($this->medias as $media){
				if ($media->getIsPdf()) {
					$thumbnail = $media->getUrl();
					break;
				}
			}
		}
		// send generic image if empty
		return ($thumbnail) ? $thumbnail : 'typo3conf/ext/wpj/Resources/Public/img/weimarpedia_platzhalter_logo.gif';
	}
	
	
	/**
	 * Adds a Media
	 *
	 * @param Tx_Wpj_Domain_Model_media The Media to be added
	 * @return void
	 */
	public function addMedia(Tx_Wpj_Domain_Model_media $media) {
		if (!$this->medias->contains($media)) $this->medias->attach($media);
	}
	
	/**
	 * Removes a Media
	 *
	 * @param Tx_Wpj_Domain_Model_media The Media to be removed
	 * @return void
	 */
	public function removeMedia(Tx_Wpj_Domain_Model_media $media) {
		$this->medias->detach($media);
	}
	
	/**
	 * Setter for articletype
	 *
	 * @param Tx_Wpj_Domain_Model_articletype $articletype articletype
	 * @return void
	 */
	public function setArticletype(Tx_Wpj_Domain_Model_articletype $articletype) {
		$this->articletype = $articletype;
	}

	/**
	 * Getter for articletype
	 *
	 * @return Tx_Wpj_Domain_Model_articletype articletype
	 */
	public function getArticletype() {
		return $this->articletype;
	}
	
	/**
	 * Getter for articletype as string
	 *
	 * @return String articletype (only exhibition or knowledge)
	 */
	public function getArticletypeCSSClass() {
		$class = '';
        if ($this->articletype == null) return $class;
		if ($this->articletype->getUid() == 10) $class = 'exhibition';
		else if ($this->articletype->getUid() < 10) $class = 'knowledge';
		return $class;
	}

	/**
	 * Setter for authors
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_author> $authors authors
	 * @return void
	 */
	public function setAuthors(Tx_Extbase_Persistence_ObjectStorage $authors) {
		$this->authors = $authors;
	}

	/**
	 * Getter for authors
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Wpj_Domain_Model_author> authors
	 */
	public function getAuthors() {
		return $this->authors;
	}
	
	
	/**
	 * Getter for first author
	 *
	 * @return Tx_Wpj_Domain_Model_author author
	 */
	public function getAuthor() {
        $authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$this->authors->rewind();
		$author = $this->authors->current();
		return $author;
	}
	
	/**
	 * checks if $author is an author of the article 
     * 
	 * @param Tx_Wpj_Domain_Model_author
	 * @return boolean
	 */
	public function hasAuthor(Tx_Wpj_Domain_Model_author $author) {
		return $this->authors->contains($author);
	}
	
	/**
	 * checks if $userUid belongs to an author of the article
     * 
	 * @param integer $userUid
	 * @return boolean
	 */
	public function hasAuthorByUserUid($userUid) {
		$author = $this->authorFromUserUid($userUid);
		return $this->authors->contains($author);
	}
		
	/**
	 * Adds a Author
	 *
	 * @param Tx_Wpj_Domain_Model_author The Author to be added
	 * @return void
	 */
	public function addAuthor(Tx_Wpj_Domain_Model_author $author) {
		if ( !$this->hasAuthor($author) ) $this->authors->attach($author);
	}
	
	/**
	 * Adds a Author
	 *
	 * @param integer
	 * @return void
	 */
	public function addAuthorByUserUid($userUid) {
		$author = $this->authorFromUserUid($userUid);
		if ( $author && !$this->hasAuthor($author) ) $this->authors->attach($author);
	}
		
	/**
	 * Removes a Author
	 *
	 * @param Tx_Wpj_Domain_Model_author The Author to be removed
	 * @return void
	 */
	public function removeAuthor(Tx_Wpj_Domain_Model_author $author) {
		$this->authors->detach($author);
	}

	/**
	 * Getter for updatedAt
	 *
	 * @return DateTime
	 */
	public function getUpdatedAt() {
		return strftime("%Y/%m/%d %H:%I",$this->tstamp);
	}

	/**
	 * Getter for createdAt
	 *
	 * @return DateTime
	 */
	public function getCreatedAt() {
		return strftime("%Y/%m/%d %H:%I",$this->crdate);
	}
	
	/**
	 * Returns an descriptive string for an article version
	 * 
	 * @return String
	 */
	public function getVersionLabel() {
		$label = $this->t3ver_label;
		$author_id = explode("'", $label);
		$author_id = intval( $author_id[1] );
		$authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$author = $authorRepository->findByUid($author_id);
		if ($author) $authorStr = " von " . $author->getShortName();
		return strftime("%Y/%m/%d %H:%I",$this->crdate) . $authorStr;
	}


	/**
	 * Returns the number of chars as an indicator for a specific version
	 * 
	 * @return String
	 */
	public function getVersionDescription() {
		
		if ( empty($this->title) ) $titleDesc = "leer";
		//else if ($article->getTitle() == $this->title) $titleDesc = "unverändert";
		else $titleDesc = strlen(trim($this->title))." Zeichen";
		
		if ( empty($this->body) ) $bodyDesc = "leer";
		//else if ($article->getTitle() == $this->body) $bodyDesc = "unverändert";
		else $bodyDesc = strlen(trim($this->body))." Zeichen";
		
		return "Titel $titleDesc / Text $bodyDesc";
	}
	
	/**
	 * Returns a html string with removed and added parts of the title
	 * 
	 * @return String
	 */
	public function getVersionDiffTitle($article) {
		return $this->htmlDiff($article->title, $this->title);
	}
	
    /**
     * Returns a html string with removed and added parts of the body
     * 
     * @return String
     */
    public function getVersionDiffBody($article) {
        return $this->htmlDiff($article->body,$this->body);
    }
    
    /**
     * Returns a css class "not-reviewed" for classifying articles
     * 
     * @return String
     */
	public function getReviewedCSSClass(){
		return ($this->reviewed) ? "" : "not-reviewed";
	}
	
    /**
     * Returns a css class own articles
     * 
     * @return String
     */
	public function getOwnerCSSClass(){
		$userUid = (int) $GLOBALS["TSFE"]->fe_user->user['uid'];
		return ($this->hasAuthorByUserUid($userUid)) ? "my-article" : "";
	}
	
	/**
	 * 
	 *
	 * @param integer $userUid
	 * @return Tx_Wpj_Domain_Model_author
	 */
	private function authorFromUserUid($userUid){
		if ($userUid == null) return false;
		$authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		$author = $authorRepository->findByUid( (int)$userUid );
		return $author;
	}
	
	
	/*
	Paul's Simple Diff Algorithm v 0.1
	(C) Paul Butler 2007 <http://www.paulbutler.org/>
	May be used and distributed under the zlib/libpng license.
	
	*/
	
	private function diff($old, $new){
		foreach($old as $oindex => $ovalue){
		$nkeys = array_keys($new, $ovalue);
		foreach($nkeys as $nindex){
			$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
			$matrix[$oindex - 1][$nindex - 1] + 1 : 1;
			if($matrix[$oindex][$nindex] > $maxlen){
				$maxlen = $matrix[$oindex][$nindex];
				$omax = $oindex + 1 - $maxlen;
				$nmax = $nindex + 1 - $maxlen;
			}
			}
		}
		if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
		return array_merge(
			$this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
			array_slice($new, $nmax, $maxlen),
			$this->diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
		);
	}
	
	private function htmlDiff($old, $new){
		$diff = $this->diff(explode(' ', $old), explode(' ', $new));
		foreach($diff as $k){
			if(is_array($k))
				$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
				(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
			else $ret .= $k . ' ';
		}
		return $ret;
	}
}
?>