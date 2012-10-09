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

class Tx_Wpj_ViewHelpers_UserStatusViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	
	public function render() {
		
		$uriBuilder = $this->controllerContext->getUriBuilder();
		
		if ( $GLOBALS['TSFE']->loginUser ) {
			// account
			$accountUri = $uriBuilder
				->reset()
				->uriFor("index", array(), "account");	
			$this->tag = new Tx_Fluid_Core_ViewHelper_TagBuilder("a", $GLOBALS["TSFE"]->fe_user->user['name']);
			$this->tag->addAttribute('href', $accountUri, true);
			$this->tag->addAttribute('id', 'accountLink', true);
			$accountLink .= $this->tag->render();
			$output = 'Hallo '.$accountLink.'! ';
			// logout
			$logoutUri = $uriBuilder
				->reset()
				->uriFor("logout", array(), "session");	
			$this->tag = new Tx_Fluid_Core_ViewHelper_TagBuilder("a", "Abmelden");
			$this->tag->addAttribute('href', $logoutUri, true);
			$output .= $this->tag->render();
		} else {
			$loginUri = $uriBuilder
				->reset()
				->uriFor("loginForm", array(), "session");
			$this->tag = new Tx_Fluid_Core_ViewHelper_TagBuilder("a", "Anmelden");
			$this->tag->addAttribute('href', $loginUri, true);
			$output = $this->tag->render();
		}
		
		return '<span id="userStatus">'.$output.'</span>';
	}
	
}
?>