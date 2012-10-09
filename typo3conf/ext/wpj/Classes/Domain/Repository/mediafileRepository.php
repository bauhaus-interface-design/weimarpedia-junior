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
 * Repository for Tx_Wpj_Domain_Model_mediafile
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Repository_mediafileRepository extends Tx_Extbase_Persistence_Repository {
    
    /**
     * Search for a mediafiel by searchterm
     *
     * @param String $searchterm
     * @return array of Tx_Wpj_Domain_Model_mediafile
     */
    public function search($searchterm) {
        $searchtermWrapped = '%'.$searchterm.'%';
        $query = $this->createQuery();
        $result = $query->matching(
            $query->logicalOr(array(
                $query->equals('uid',$searchterm),
                $query->like('title',$searchtermWrapped),
                $query->like('file',$searchtermWrapped)
            ))
        )->execute();
        return $result;
    }
}
?>