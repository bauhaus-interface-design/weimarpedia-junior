<?php

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