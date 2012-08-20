<?php
/***************************************************************
*  Copyright notice
*
*  (c)  TODO - INSERT COPYRIGHT
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
 * Repository for Tx_Wpj_Domain_Model_place
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Repository_placeRepository extends Tx_Extbase_Persistence_Repository {
	/**
	 * 
	 * @return Tx_Wpj_Domain_Model_place objects
	 */
	public function findRoot() {
		$query = $this->createQuery();
		$query->matching($query->equals('parent', 0));
		return $query->execute();
	}
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function findAllChildren(Tx_Wpj_Domain_Model_Place $place) {
		$query = $this->createQuery();
		$query->matching($query->equals('parent', $place));
		$query->setOrderings(array('name' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		return $query->execute();
	}
	
	
	/**
	 * .
	 *
	 * @param string searchterm
	 * @return array The tags
	 */
	public function search($term, $accuracy=NULL) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->like('name', "$term");
		if ($accuracy > 0) $constraints[] = $query->equals('accuracy', $accuracy);
		else if ($accuracy < 0) $constraints[] = $query->lessThanOrEqual('accuracy', $accuracy*-1);
		return $query->matching( $query->logicalAnd($constraints) )
			->execute();
	}
	
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_article objects
	 */
	public function getArticlesOfPlace(Tx_Wpj_Domain_Model_Place $place){
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		return $query->statement('
SELECT DISTINCT a.*, p.*
FROM `tx_wpj_domain_model_place` p
INNER JOIN (`tx_wpj_domain_model_tag` t, `tx_wpj_article_tag_mm` mm, `tx_wpj_domain_model_article` a) ON 
(p.uid=t.place AND mm.uid_foreign = t.uid AND mm.uid_local = a.uid)
WHERE p.uid='.$place->getUid().'
')->execute();	
		
	}
	
	

	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function findWithinBounds($sLat, $wLng, $nLat, $eLng, $accuracy=7) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('accuracy', $accuracy);
		$constraints[] = $query->greaterThan('lat', $sLat);
		$constraints[] = $query->greaterThan('lng', $wLng);
		$constraints[] = $query->lessThan('lat', $nLat);
		$constraints[] = $query->lessThan('lng', $eLng);
		
		$query->matching( $query->logicalAnd($constraints) ); 
		
		return $query->execute();
	}
	
	
	

	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function findWithinBoundsAsArray($sLat, $wLng, $nLat, $eLng, $accuracy=7) {
		$result = $this->findWithinBounds($sLat, $wLng, $nLat, $eLng, $accuracy)->toArray();
		
		$array = array();
		foreach ($result as $place){
			$array[] = array(
				'uid' => $place->getUid(),
				'lat' => $place->getLat(),
				'lng' => $place->getLng(),
				'name' => $place->getName(),
				'icon' => $place->getIcon(),
			);
		}

		return $array;
	}
	
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function findByNameAndAccuracy($name, $accuracy) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('accuracy', $accuracy);
		$constraints[] = $query->equals('name', $name);
		
		$query->matching( $query->logicalAnd($constraints) ); 
		$result = $query->execute();
		return $result->getFirst();
	}
	
	
	
	/**
	 * suggest places by searchterm 
	 * 
	 * @return array an unique array with keys "value", "type" and "label"
	 */
	public function suggestAsArray($term, $accuracy = NULL, $maxResults=20) {
		// find places by searchterm: term%
		$places = $this->search($term."%", $accuracy);
		// if too less results: search with %term%
		if (count($places) < $maxResults) $places = $this->search("%".$term."%", $accuracy);
		
		// collect in array (for json conversion) and make unique
		$uids = array();
		$response = array();	
		foreach ($places as $place){	
			$r = array();
			$r['uid'] = $place->getUid();
		    $r['value'] = $place->getName();
		    $r['label'] = $place->getName();
		    if ($place->getAccuracy() > 1) {
		    	if ($place->getAccuracy() == 7) { // building
					$r['label'] .= " (".$place->getParent()->getParent()->getName().")";
				} else {
					$r['label'] .= " (".$place->getParent()->getName().")";
				}
			}
		    if (!in_array( $place->getUid() , $uids)){ // make unique
				$response[] = $r;
		    	$uids[] = $place->getUid();
			}
			
		    // children
		    /*
			$children = $place->getChildren();
		    if ($children && count($places) < $maxResults*2){
		    	foreach ($children as $cplace){	
					$r = array();
					$r['value'] = $cplace->getUid();
				    $r['label'] = "> ".$cplace->getName();
					if ($place->getAccuracy() == 8) $r['label'] .= " (".$place->getParent()->getName().")"; // Stockwerk needs a Building
		    		$r['type'] = "place";
				    if (!in_array( $place->getUid() , $uids)){ // make unique
						$response[] = $r;
				    	array_push($place->getUid());
					}
		    	}
		    }
			*/
		    if (count($response) > $maxResults) break;
		}
		return $response;
	}



	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function getFloors($place) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('accuracy', 8);
		$constraints[] = $query->equals('parent', $place->getUid());
		
		$query->matching( $query->logicalAnd($constraints) ); 
		$result = $query->execute();
		
		$array = array();
		foreach ($result as $place){
			$array[] = array(
				'uid' => $place->getUid(),
				'name' => $place->getName(),
				'icon' => $place->getIcon(),
				'image' => $place->getImage(),
			);
		}

		return $array;
	}
	
	
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function collectChildren($place) {
		$place = (is_array($place))? $place : array($place);	
		$children = $this->findAllChildren2($place)->toArray();
		$children2 = array_merge( $children, $this->collectChildren($children)->toArray());
		// 
		
		return $children2;
	}
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
	 */
	public function findAllChildren2($place) {
		$query = $this->createQuery();
		$query->matching($query->in('parent', $place));
		return $query->execute();
	}
	
	
	
	// plain sql version is faster:
	public function collectChildrenUidsFast($place){
		$children = array();
		$childPlaces = $this->placeRepository->collectChildrenFast($place);
		foreach ($childPlaces as $place){
			$children[] = $place->getUid();
		}
		return join(',', $children);
	}

	public function collectChildrenFast($place) {// building
		$floors = $this->findChildrenFast($place); 
		$rooms = $this->findChildrenFast($children); 
		return array_merge( $floors, $rooms);
	}
	
	public function findChildrenFast($place) {
		$uid = $this->collectUids($place);
		if ($uid){
			$query = $this->createQuery();
			$result = $query->statement('
			SELECT uid,name FROM `tx_wpj_domain_model_place` WHERE parent IN ('.$uid.')
			')->execute();
			return $result->toArray();
			
		} else return array();
	}
	
	private function collectUids($a){
		// single	
		if (get_class($a) == 'Tx_Wpj_Domain_Model_place') return $a->getUid();	
		// array / queryresult
		$c = array();	
		foreach ($a as $b){
			$c[] = $b->getUid();
		}
		return join(',',$c);
	}
	
	
}


?>