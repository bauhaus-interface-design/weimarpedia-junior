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
    
	/**
	 * Finds all articles filtered by different options
	 *
	 * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
	 * @param Tx_Wpj_Domain_Model_tag $tag 
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
	 * @param Tx_Wpj_Domain_Model_author $author
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
	 * Finds articles by searching the term in authors
	 *
     * @param string $term
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
     * @param array|Tx_Wpj_Domain_Model_author $authors
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
	 * Finds articles by the specified schools
	 *
     * @param array|Tx_Wpj_Domain_Model_school $schools
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
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
	 * Finds all articles with voting=1 within the last year
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
	 * Finds all articles with voting=1 alltime
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
	 * Search articles (title, body) by words (sql match)
	 *
	 * @param Tx_Wpj_Domain_Model_Demand $demand
     * @param integer $reviewed 1/0
     * @param string $scope knowledge/gallery/objects/people/''
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
				a.deleted=0 AND
				a.hidden=0 AND 
				( MATCH (a.body) AGAINST ("'.$demand->getSearchterm().'") OR MATCH (a.title) AGAINST ("'.$demand->getSearchterm().'") )
			ORDER BY A*10+B DESC
		';
		return $this->query->statement($sql)->execute();
	}
		
	
	/**
	 * Search articles (title, body) by string fragments (sql like)
	 *
	 * @param Tx_Wpj_Domain_Model_Demand $demand
     * @param integer $reviewed 1/0
     * @param string $scope knowledge/gallery/objects/people/''
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
	
    /**
     * Search articles (title, body) by string fragments (sql like)
     *
     * @param integer $reviewed 1/0
     * @param string $type knowledge/gallery/''
     * @param string $order field for ordering
     * @param string $orderSequence ASC/DESC
     * @param integer $limit The number of articles to return at max
     * @return array The articles
     */
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
	 * Returns all public visible articles for the specified place
     * 
     * @param Tx_Wpj_Domain_Model_place $placeUid UID of place
     * @param string $type knowledge/gallery/''
	 * @return array an array of Tx_Wpj_Domain_Model_place objects
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
		WHERE p.uid IN ('.$placeUid.') AND t.taxonomy!=2 '.$type_sql.' AND a.pid=1 AND a.deleted=0 AND a.hidden=0 AND a.reviewed>0 
		')->execute();	
		
	}
	
    
    /**
     * Returns all public visible reference articles for the specified place
     * 
     * @param Tx_Wpj_Domain_Model_place $placeUid UID of place
     * @param string $type knowledge/gallery/''
     * @return array an array of Tx_Wpj_Domain_Model_place objects
     */
    public function getReferenceArticlesOfPlaceUid($placeUid, $type=NULL){
        if ($type!=NULL){
            $type_sql = ($type=="knowledge")? 'AND (a.articletype>0 AND a.articletype<10) ' : 'AND (a.articletype>9 AND a.articletype<20) ';
        }   
        $query = $this->createQuery();
        return $query->statement('
        SELECT DISTINCT a.*
        FROM `tx_wpj_domain_model_place` p
        INNER JOIN (`tx_wpj_domain_model_tag` t, `tx_wpj_article_tag_mm` mm, `tx_wpj_domain_model_article` a) ON 
        (p.uid=t.place AND mm.uid_foreign = t.uid AND mm.uid_local = a.uid)
        WHERE p.uid IN ('.$placeUid.') AND t.taxonomy=2 '.$type_sql.' AND a.pid=1 AND a.deleted=0 AND a.hidden=0 AND a.reviewed>0
        ')->execute(); 
    }
	
	
	/**
	 * Copy article with pid=-1
	 *
	 * @param Tx_Wpj_Domain_Model_article 
     * @param boolean $autosave 
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
	 * Find all versions (pid=-1) of the specified article
	 *
	 * @param Tx_Wpj_Domain_Model_article 
	 * @return array an array of Tx_Wpj_Domain_Model_article objects
	 */
	public function findAllVersions($article){
		$this->query = $this->createQuery();
		return $this->query->statement('
SELECT * FROM `tx_wpj_domain_model_article` WHERE pid=-1 AND t3ver_oid='.$article->getUid().' AND deleted=0 AND hidden=0
 ORDER BY tstamp DESC')->execute();
	}
	
    
    private function buildObsoleteVersionsSql() {
        $this->obsoleteVersionsSql = ' WHERE (pid=-1 AND t3ver_oid>0 AND deleted=0 AND tstamp<' . (time()-60*60*24*356) . ')
         ORDER BY tstamp ASC LIMIT 100;';    
    }

	/**
	 * Returns all obsolete (defined by buildObsoleteVersionsSql()) versions of the specified article
	 *
	 * @param Tx_Wpj_Domain_Model_article 
     * @return array an array of Tx_Wpj_Domain_Model_article objects
	 */
	public function findAllObsoleteVersions(){
	    $this->buildObsoleteVersionsSql();
		$this->query = $this->createQuery();
		$this->query->getQuerySettings()->setReturnRawQueryResult( TRUE ); 
        $this->query->statement('SELECT uid,title,tstamp FROM `tx_wpj_domain_model_article` '. $this->obsoleteVersionsSql);
		return $this->query->execute();
	}


    /**
     * Deletes all obsolete (defined by buildObsoleteVersionsSql()) versions of the specified article by setting deleted=0
     *
     * @param Tx_Wpj_Domain_Model_article 
     * @return object
     */
    public function cleanUpObsoleteVersions(){
        $this->buildObsoleteVersionsSql();
        $this->query = $this->createQuery();
        $this->query->getQuerySettings()->setReturnRawQueryResult( TRUE ); 
        $this->query->statement('UPDATE `tx_wpj_domain_model_article` SET deleted=1 ' . $this->obsoleteVersionsSql );
        return $this->query->execute();
    }
    

	/**
	 * Returns the specified version of an article
	 *
	 * @param int UID of version 
	 * @return Tx_Wpj_Domain_Model_article
	 */
	public function findVersion($uid){
		$this->query = $this->createQuery();
		return $this->query->statement('
SELECT * FROM `tx_wpj_domain_model_article` WHERE pid=-1 AND uid='.$uid.'')->execute()->getFirst();
	}
}
?>