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
 * Controller manage map-views
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_pagesController extends Tx_Extbase_MVC_Controller_ActionController {
		
	/**
	 * @var Tx_Wpj_Domain_Repository_articleRepository
	 */
	protected $articleRepository;
		
	/**
	 * @var Tx_Wpj_Domain_Repository_placeRepository
	 */
	protected $placeRepository;
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		//$this->articleRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_articleRepository');
		$this->placeRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_placeRepository');
		//$authorRepository = t3lib_div::makeInstance('Tx_Wpj_Domain_Repository_authorRepository');
		//$this->author = $authorRepository->findByUid( (int)$GLOBALS["TSFE"]->fe_user->user['uid'] );
	}
	
	/**
	 * List action for this controller.
	 */
	public function indexAction() {
		$places = $this->placeRepository->findAll();
		$this->view->assign('places', $places);
		$this->addGMapJS();
		
		$loadMapXmlUrl = 	$this->uriBuilder->uriFor('loadMapXml', array( ), 'map');
		$additionalHeaderData = '
            <script type="text/javascript">
            <!--
                var loadMapXmlUrl = 	"'.$loadMapXmlUrl.'";
        	// -->
        	</script>';
        $this->response->addAdditionalHeaderData($additionalHeaderData); 
        
		
	}
	
}
?>