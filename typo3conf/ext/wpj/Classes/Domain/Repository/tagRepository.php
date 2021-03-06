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
 * Repository for Tx_Wpj_Domain_Model_tag
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Repository_tagRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Searchs for a school
	 *
	 * @param string searchterm
	 * @return array an array of Tx_Wpj_Domain_Model_tag objects
	 */
	public function search($term) {
		$this->query = $this->createQuery();
		return $this->query->matching($this->query->like('name', "$term"))
			->execute();
	}
	
	/**
	 * Returns tags for an article and a given taxonomy
	 *
	 * @param Tx_Wpj_Domain_Model_article $article
     * @param Tx_Wpj_Domain_Model_taxonomy $taxonomy
	 * @return array an array of Tx_Wpj_Domain_Model_tag objects
	 */
	public function findByArticleAndTaxonomy($article, $taxonomy) {
		$this->query = $this->createQuery();
		return $this->query->matching(
			$this->query->logicalAnd(
				$this->query->equals('article', $article),
				$this->query->equals('taxonomy', $taxonomy)
			)
		)->execute();
	}
	
	/**
	 * suggest tags by searchterm 
	 * 
     * @param string searchterm
     * @param integer $maxResults
	 * @return array an unique array with keys "value", "type" and "label"
	 */
	public function suggestAsArray($term, $maxResults=20) {
	
		$tags = $this->search($term."%");
		// if too less results: search with %term%
		if (count($tags) < $maxResults) $tags = $this->search("%".$term."%");
		
		// collect in array (for json conversion) and make unique
		$uids = array();
		$response = array();	
		foreach ($tags as $tag){	
			$r = array();
			$r['uid'] = $tag->getUid();
			$r['value'] = $tag->getUid();
		    $r['label'] = $tag->getName();
			$taxonomy = $tag->getTaxonomy();
			if ($taxonomy) $r['taxonomy'] = $taxonomy->getUid(); 
		    if (!in_array( $tag->getUid() , $uids)){ // make unique
				$response[] = $r;
		    	$uids[] = $tag->getUid();
			}
		    if (count($response) > $maxResults) break;
		}
		return $response;
	}
	
	
	/**
	 * Find or creates a tag for a place
	 *
	 * @param integer $placeId
     * @param integer $taxonomyId
	 * @return array an array of Tx_Wpj_Domain_Model_tag objects
	 */
	public function findOrCreateByPlaceAndTaxonomy($placeId, $taxonomyId) {
		$tag = $this->findOneByPlaceAndTaxonomy($placeId, $taxonomyId);
		if (!$tag) {
			// create new
			$placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
			$place = $placeRepository->findByUid($placeId);
			$taxonomyRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_taxonomyRepository');
			$taxonomy = $taxonomyRepository->findByUid($taxonomyId);
			$tag = new Tx_Wpj_Domain_Model_tag();
			$tag->setPlace($place);
			$tag->setTaxonomy($taxonomy);
			$name = $place->getName();
			if ($place->getAccuracy() == 7) { // building
				$name .= " (".$place->getParent()->getParent()->getName().")";
			}
			$tag->setName($name);
			$this->add($tag);
		}
		return $tag;
	}
	
	
	/**
	 * Finds a tag for a place
	 *
	 * @param Tx_Wpj_Domain_Model_place $place
     * @param Tx_Wpj_Domain_Model_taxonomy $taxonomy
	 * @return Tx_Wpj_Domain_Model_tag tag
	 */
	public function findOneByPlaceAndTaxonomy($place, $taxonomy) {
		$this->query = $this->createQuery();
		return $this->query->matching(
			$this->query->logicalAnd(
				$this->query->equals('place', $place),
				$this->query->equals('taxonomy', $taxonomy)
			)
		)->execute()->getFirst();
	}
				
	
	/**
	 * Finds a tag by name
     *
     * @param String $name
     * @param Tx_Wpj_Domain_Model_taxonomy $taxonomy
     * @return Tx_Wpj_Domain_Model_tag tag
	 */
	public function findOneByLabelAndTaxonomy($name, $taxonomy) {
		$this->query = $this->createQuery();
		return $this->query->matching(
			$this->query->logicalAnd(
				$this->query->equals('name', $name),
				$this->query->equals('taxonomy', $taxonomy)
			)
		)->execute()->getFirst();
	}			
}
?>