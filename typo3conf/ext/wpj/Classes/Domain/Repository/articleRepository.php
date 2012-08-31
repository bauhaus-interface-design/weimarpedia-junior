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
 * Repository for Tx_Wpj_Domain_Model_article
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Repository_articleRepository extends Tx_Extbase_Persistence_Repository {
	
	protected $defaultOrderings = array(
		'tstamp' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
	);
	
	protected $query;
	
    /**
     * conditions for obsolete article versions
     * @var String
     */
    protected $obsoleteVersionsSql;
    
    
    
	public function initializeObject() {
		$this->query = $this->createQuery();
        $this->obsoleteVersionsSql = ' WHERE pid=-1 AND t3ver_oid>0 AND tstamp<' . (time()-60*60*24*356) . ' AND deleted=0 ORDER BY tstamp DESC LIMIT 100';
	}
	
	/**
	 * Finds all articles ...
	 *
	 * @param 
	 * @return array The articles
	 */
	public function findAll($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching( 
			$this->query->logicalAnd($q_reviewed, $q_type) 
		);
		return $this->query->execute();
	}	

	/**
	 * Finds articles by the specified tag
	 *
	 * @param integer $tag_id
	 * @param integer $limit The number of posts to return at max
	 * @return array The articles
	 */
	public function findByTag($tag, $reviewed, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching(
			$this->query->logicalAnd(	$q_reviewed, 
				$this->query->logicalAnd($q_type,
					$this->query->equals('tags.uid', $tag->getUid())
				)
			)
		);
		return $this->query->execute();
	}

	/**
	 * Finds articles by the specified author
	 *
	 * @param integer $author_id
	 * @param integer $limit The number of posts to return at max
	 * @return array The articles
	 */
	public function findByAuthor($author, $reviewed, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching(
			$this->query->logicalAnd( $q_reviewed, 
				$this->query->logicalAnd($q_type,
					$this->query->equals('authors.uid', $author->getUid())
				)
			)
		);
		return $this->query->execute();
	}

	/**
	 * Finds articles by the specified author
	 *
	 * @param integer $author_id
	 * @param integer $limit The number of posts to return at max
	 * @return array The articles
	 */
	public function findByAuthorSearch($term, $reviewed, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching(
			$this->query->logicalAnd( $q_reviewed, 
				$this->query->logicalAnd(
					$q_type,
					$this->query->logicalOr(array(
						$this->query->like('authors.username', $term),
						$this->query->like('authors.name', "%$term%"),
						$this->query->like('authors.address', "%$term%")
					))
				)
			)
		);
		return $this->query->execute();
	}
	
	/**
	 * Finds articles by the specified authors
	 *
	
	 * @return array The articles
	 */
	public function findByAuthors($authors, $reviewed, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching(
			$this->query->logicalAnd( $q_reviewed, 
				$this->query->logicalAnd($q_type,
					$this->query->in('authors.uid', $authors)
				)
			)
		);
		return $this->query->execute();
	}

	
	/**
	 * Finds articles by the specified authors
	 *
	
	 * @return array The articles
	 */
	public function findBySchools($schools, $reviewed, $type="", $order="tstamp", $orderSequence="DESC", $limit=NULL) {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $type, $order, $orderSequence, $limit);
		$this->query->matching(
			$this->query->logicalAnd( $q_reviewed, 
				$this->query->logicalAnd($q_type,
					$this->query->in('authors.tx_wpj_school', $schools)
				)
			)
		);
		return $this->query->execute();
	}
	
	
	/**
	 * Finds all articles ...
	 *
	 * @param 
	 * @return array The articles
	 */
	public function findTopYear() {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts(1, 'gallery', "tstamp", "DESC", 20);
		$this->query->matching( 
			$this->query->logicalAnd(
				$q_reviewed, $q_type, 
				$this->query->equals('voting', 1),
				$this->query->greaterThan('tstamp', time()-(356 * 24 * 60 * 60))
			) 
		);
		return $this->query->execute();
	}	
	
	/**
	 * Finds all articles ...
	 *
	 * @param 
	 * @return array The articles
	 */
	public function findTopAlltime() {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts(1, 'gallery', "tstamp", "ASC", 20);
		$this->query->matching( 
			$this->query->logicalAnd(
				$q_reviewed, $q_type, 
				$this->query->equals('voting', 2)
			) 
		);
		return $this->query->execute();
	}
	
	/**
	 * 
	 *
	 * @param 
	 * @return array The articles
	 */
	public function search(Tx_Wpj_Domain_Model_Demand $demand, $reviewed=1, $scope="") {
		$this->query = $this->createQuery();
		$scope = (!empty($scope))? $scope : $demand->getScope();
		
		//if ($demand->getLimit() > 0) $this->query->setLimit($demand);
		switch ( $scope ) {
			case "knowledge": 
				$typesql = '(a.articletype>0 AND a.articletype<10)';
				break;
			case "gallery": 
				$typesql = '(a.articletype>=10 AND a.articletype<20)';
				break;
			case "objects": 
				$typesql = '(a.articletype=3)';
				break;
			case "people": 
				$typesql = '(a.articletype=2)';
				break;
			default: 
				$typesql = '(a.articletype>0 AND a.articletype<20)';
				break;
		}
		
		$reviewedsql = ($reviewed === '') ? '' : ($reviewed == 0)? 'reviewed=0 AND ' : 'reviewed>0 AND ';
		
		$sql = '
			SELECT DISTINCT a.*, 
				MATCH (a.title) AGAINST ("'.$demand->getSearchterm().'") A,
				MATCH (a.body) AGAINST ("'.$demand->getSearchterm().'") B 
			FROM `tx_wpj_domain_model_article` a
			WHERE 
				'.$reviewedsql.'
				a.pid=1 AND '.$typesql.' AND 
				a.deleted!=-1 AND
				a.hidden=0 AND 
				( MATCH (a.body) AGAINST ("'.$demand->getSearchterm().'") OR MATCH (a.title) AGAINST ("'.$demand->getSearchterm().'") )
			ORDER BY A*10+B DESC
		';
		return $this->query->statement($sql)->execute();
	}
	
//	SELECT DISTINCT a.uid, a.title, t.uid, t.name, mm.uid
//FROM `tx_wpj_domain_model_tag` t
//INNER JOIN (
//`tx_wpj_domain_model_article` a, `tx_wpj_article_tag_mm` mm, `tx_wpj_domain_model_tag`
//) ON (
//mm.uid_foreign = t.uid
//AND mm.uid_local = a.uid
//)
//WHERE t.uid =17
//ORDER BY t.uid
	
	
	/**
	 * Finds all articles ...
	 *
	 * @param 
	 * @return array The articles
	 */
	public function searchLike(Tx_Wpj_Domain_Model_Demand $demand, $reviewed=1, $scope="") {
		$this->query = $this->createQuery();
		list($q_reviewed, $q_type) = $this->buildQueryParts($reviewed, $demand->getScope());
		$this->query->matching(
			$this->query->logicalAnd( array(
					$q_reviewed, 
					$q_type,
					$this->query->logicalOr(
						$this->query->like('title', "%".$demand->getSearchterm()."%"),
						$this->query->like('body', "%".$demand->getSearchterm()."%")
					)
				)
			)
		);
		return $this->query->execute();
	}
	
	private function buildQueryParts($reviewed=1, $type="knowledge", $order="tstamp", $orderSequence="DESC", $limit=NULL){
		// reviewed: 0 | 1 | both , reviewed is a timestamp in database
		if ($reviewed === '')  $q_reviewed = $this->query->greaterThan('reviewed', -1);
		else $q_reviewed = ($reviewed > 0) ? $this->query->greaterThan('reviewed', 0) : $this->query->equals('reviewed', 0);
		
		
		
		// type: '' | knowledge | gallery | type_id
		if ($type === ""){ // 1..50
			$q_type = $this->query->logicalAnd(
				$this->query->greaterThan('articletype', 0),
				$this->query->lessThan('articletype', 50)
			);
		}else if ($type == "knowledge"){ // 1..9
			$q_type = $this->query->logicalAnd(
				$this->query->greaterThan('articletype', 0),
				$this->query->lessThan('articletype', 10)
			);
		}else if ($type == "gallery"){ // 10..19
			$q_type = $this->query->logicalAnd(
				$this->query->greaterThan('articletype', 9),
				$this->query->lessThan('articletype', 20)
			);
		}else {
			$q_type = $this->query->equals('articletype', $type);
		}
		
		$this->query->setOrderings(array($order => ($orderSequence == "DESC") ? Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING : Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		if (!empty($limit)) $this->query->setLimit($limit);
		
		return array($q_reviewed, $q_type);
	}
	
	
	
	
	
	
	
	/**
	 * 
	 * @return array an array of Tx_Wpj_Domain_Model_article objects
	 */
	public function getArticlesOfPlaceUid($placeUid, $type=NULL){
		if ($type!=NULL){
			$type_sql = ($type=="knowledge")? 'AND (a.articletype>0 AND a.articletype<10) ' : 'AND (a.articletype>9 AND a.articletype<20) ';
		} 	
		$query = $this->createQuery();
		return $query->statement('
		SELECT DISTINCT a.*
		FROM `tx_wpj_domain_model_place` p
		INNER JOIN (`tx_wpj_domain_model_tag` t, `tx_wpj_article_tag_mm` mm, `tx_wpj_domain_model_article` a) ON 
		(p.uid=t.place AND mm.uid_foreign = t.uid AND mm.uid_local = a.uid)
		WHERE p.uid IN ('.$placeUid.') '.$type_sql.'
		')->execute();	
		
	}
	
	
	
	
	
	
	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article 
	 * @return object
	 */
	public function backup($article, $autosave=false){
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		// find latest version
		$version = $this->query->statement('
SELECT MAX(t3ver_id) AS version FROM `tx_wpj_domain_model_article` WHERE t3ver_oid='.$article->getUid().'
')->execute();
		$version = $version[0]['version'] + 1;
		$comment = ($autosave) ? "Autosave by user '" : "Version by user '";
		$comment .= $GLOBALS["TSFE"]->fe_user->user['uid']."'";
		// duplicate entry and update versioning fields
		$fields = 'pid,title,body,reviewed,tags,medias,articletype,authors,tstamp,crdate,deleted,hidden,t3ver_oid,				t3ver_id,	t3ver_wsid ,t3ver_label,t3ver_state ,	t3ver_stage,t3ver_count ,t3ver_tstamp,t3_origuid';
		$fields2 = '-1,title,body,reviewed,tags,medias,articletype,authors,tstamp,crdate,deleted,hidden,'.$article->getUid().',	'.$version.',	t3ver_wsid ,"'.$comment.'" ,t3ver_state ,	t3ver_stage,t3ver_count ,t3ver_tstamp,t3_origuid';
		return $this->query->statement('
		INSERT INTO `tx_wpj_domain_model_article` ('.$fields.') 
		SELECT '.$fields2.' FROM `tx_wpj_domain_model_article` WHERE uid='.$article->getUid().'
		')->execute();
		
	}
	
	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article 
	 * @return object
	 */
	public function findAllVersions($article){
		$this->query = $this->createQuery();
		return $this->query->statement('
SELECT * FROM `tx_wpj_domain_model_article` WHERE pid=-1 AND t3ver_oid='.$article->getUid().'
 ORDER BY tstamp DESC')->execute();
	}
	
	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article 
	 * @return object
	 */
	public function findAllObsoleteVersions(){
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE ); 
		return $this->query->statement('
SELECT uid,title,tstamp FROM `tx_wpj_domain_model_article`  ' . $obsoleteVersionsSql)->execute();
	}


    /**
     * 
     *
     * @param Tx_Wpj_Domain_Model_article 
     * @return object
     */
    public function cleanUpObsoleteVersions(){
        $this->query = $this->createQuery();
        $this->query->getQuerySettings()->setReturnRawQueryResult( TRUE ); 
        return $this->query->statement('
UPDATE `tx_wpj_domain_model_article` SET deleted=1 ' . $obsoleteVersionsSql )->execute();
    }
    

	/**
	 * 
	 *
	 * @param Tx_Wpj_Domain_Model_article 
	 * @return object
	 */
	public function findVersion($uid){
		$this->query = $this->createQuery();
		return $this->query->statement('
SELECT * FROM `tx_wpj_domain_model_article` WHERE pid=-1 AND uid='.$uid.'')->execute()->getFirst();
	}
}
?>