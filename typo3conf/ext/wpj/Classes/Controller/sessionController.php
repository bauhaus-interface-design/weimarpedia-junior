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
 * Controller for login/logout
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpj_Controller_sessionController extends Tx_Wpj_Controller_protectedController {
	
	/**
  	* Shows the login form
    * 
    * @return void
  	*/
	public function loginFormAction() {
		if ($this->request->hasArgument('uname')){
			$uname = $this->request->getArgument('uname');
			$this->view->assign('uname', $uname);
		}
		if (!$this->hasReferer()) $this->storeReferer($_SERVER['HTTP_REFERER']);
	}
	
	
	/**
  	* Try to login by username and password
    * 
  	* @param String $uname username
  	* @param String $uident password
    * @return void
  	*/
	public function loginAction( $uname,  $uident) {
		$loginData = array(
		    'uname' => $uname, //username
		    'uident' => md5($uident), //password
		    'status' => 'login'
		);
		$GLOBALS['TSFE']->fe_user->checkPid = 0; //do not use a particular pid!
		$info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
		$user = $GLOBALS['TSFE']->fe_user->fetchUserRecord( $info['db_user'],$loginData['uname'] );
		$successful = $GLOBALS['TSFE']->fe_user->compareUident($user,$loginData);
		
		// login expired? 
		if ($successful){
			$wpj_endtime = $user['wpj_endtime'];
			$expired = (time() > $wpj_endtime && $wpj_endtime != 0);
		}
		
		if ($successful && !$expired) {
		  //login successfull
		  $this->flashMessageContainer->add('Du bist jetzt angemeldet.');
		  $GLOBALS['TSFE']->fe_user->createUserSession($user);
		  $referer = $this->loadReferer();
		  $this->clearSessionData();
		  $this->redirectToURI($referer);
		} else if ($successful && $expired) {
		  // login expired
		  $this->flashMessageContainer->add('Dein Login ist nicht mehr gültig.');
		  $this->redirect('loginForm', NULL, NULL, array('uname' => $uname));
		  
		} else {
		  //login failed
		  $this->flashMessageContainer->add('Da stimmt was nicht. Bitte versuche es noch mal.');
		  $this->redirect('loginForm', NULL, NULL, array('uname' => $uname));
		}
	}

	/**
  	* logout the user
    * 
    * @return void
  	*/
	public function logoutAction() {
		$GLOBALS['TSFE']->fe_user->logoff();
		$this->flashMessageContainer->add('Du bist abgemeldet.');
		$this->redirect('loginForm');
	}
	

	/**
	 * Loads data from session 
	 * @return String
	 */
	protected function loadReferer() {
		return $GLOBALS['TSFE']->fe_user->getKey('ses', "tx_wpj_referer");
	}
	
	/**
	 * Stores data to session.
	 * @return void
	 */
	protected function storeReferer($referer) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', "tx_wpj_referer", $referer);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}
 
    /**
     * Deletes data from session.
     * @return void
     */
	protected function clearSessionData() {
		$GLOBALS['TSFE']->fe_user->setKey('ses', "tx_wpj_referer", array());
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}
	
    
    /**
     * Returns referer from session
     * @return String
     */
	protected function hasReferer() {
		return ($this->loadReferer());
	}
	
}
?>