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
 * Controller 
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_protectedController extends Tx_Extbase_MVC_Controller_ActionController {
	
	
	/**
	 * Holds an instance of fe_user object
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $user;
	
	
	/**
	 * 
	 *
	 * @return void
	 */
	protected function allowOnlyAuthorWithMinAdminLevel($level) {
		$this->allowOnlyIfLoggedIn();
		$this->user = $GLOBALS["TSFE"]->fe_user->user;
		if ((int)$this->user['tx_wpj_admin'] < $level) $this->redirectToLogin($level);
	}
	
	/**
	 * 
	 *
	 * @return void
	 */
	protected function allowOnlyIfLoggedIn() {
		if ( !$GLOBALS['TSFE']->loginUser ) $this->redirectToLogin();
	}
	
	protected function redirectToLogin($msg='') {
		error_log('Tx_Wpj_Controller_protectedController::redirect');
		$this->flashMessageContainer->add('Bitte melde dich an. '.$msg);
		$this->forward('loginForm', 'session');
		exit();
	}
	
	/**
	 * 
	 *
	 * @return boolean
	 */
	protected function adminLevelMin($level) {
		if (!$GLOBALS['TSFE']->loginUser) return false;
		$this->user = $GLOBALS["TSFE"]->fe_user->user;
		return ($this->user['tx_wpj_admin'] >= $level) ? true : false;
		
	}
}
?>