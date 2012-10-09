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
 * Repository for Tx_Wpj_Domain_Model_author
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Repository_authorRepository extends Tx_Extbase_Domain_Repository_FrontendUserRepository {
	
	protected $findAuthorsOf = '
            SELECT u.*
            FROM `fe_users` u
            INNER JOIN (`tx_wpj_domain_model_article` a, `tx_wpj_article_author_mm` mm) ON 
            (mm.uid_foreign = u.uid AND mm.uid_local = a.uid)
            WHERE ';
    
    /**
     * Find all Authors
     *
     * @return array of Tx_Wpj_Domain_Model_author 
     */
	public function findAll() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$result = $query			
			->setOrderings(array('tstamp' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->execute();
		return $result;
	}
	
	
    /**
     * Assign all unassigned users/authors to the usergroup 1
     *
     * @return void
     */
	public function repairUsergroup(){
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
   		$persistenceManager->persistAll();
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$query->statement("UPDATE `fe_users` SET `usergroup`=1 WHERE `usergroup`='' OR `usergroup` IS NULL;")->execute();	
	}
	
	/**
     * Find all authors from a specified school
     *
     * @param Tx_Wpj_Domain_Model_school $school
     * @return Tx_Wpj_Domain_Model_author 
     */
	public function findBySchool($school) {
		$query = $this->createQuery();
		$result = $query->matching($query->equals('tx_wpj_school',$school))
			->setOrderings(array('tstamp' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->execute();
		return $result;
	}
	
	/**
	 * Search for an author in username, name and address
	 *
	 * @param string $searchterm
	 * @return array of Tx_Wpj_Domain_Model_author 
	 */
	public function search($searchterm) {
		$searchterm = '%'.$searchterm.'%';
		$query = $this->createQuery();
		$result = $query->matching(
			$query->logicalOr(array(
				$query->like('username',$searchterm),
				$query->like('name',$searchterm),
				$query->like('address',$searchterm)
			))
		)->execute();
		return $result;
	}
	
	/**
	 * Finds all authors including disabled or users with expired logins
	 * ignore all admins
	 *
     * @param Tx_Wpj_Domain_Model_article $article
	 * @return array of Tx_Wpj_Domain_Model_author 
	 */
	public function findPublicAuthorsOf($article) {
		$this->query = $this->createQuery();
		return $this->query->statement(
			$this->findAuthorsOf.'a.uid='.$article->getUid().' AND u.tx_wpj_admin < 10'
		)->execute();
	}
	
	/**
	 * Finds all authors including disabled or users with expired logins
	 * ignore all non-admins
	 *
     * @param Tx_Wpj_Domain_Model_article $article
	 * @return array of Tx_Wpj_Domain_Model_author 
	 */
	public function findHiddenAuthorsOf($article) {
		$this->query = $this->createQuery();
		return $this->query->statement(
			$this->findAuthorsOf.'a.uid='.$article->getUid().' AND u.tx_wpj_admin >= 10'
		)->execute();
	}
}
?>