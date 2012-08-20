<?php

class Tx_Wpj_ViewHelpers_IfAdminLevelViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper {
	


	/**
	 * Returns value of "then" attribute.
	 * If then attribute is not set, iterates through child nodes and renders ThenViewHelper.
	 * If then attribute is not set and no ThenViewHelper is found, all child nodes are rendered
	 *
	 * @return string rendered ThenViewHelper or contents of <f:if> if no ThenViewHelper was found
	 */
	/*protected function renderThenChild() {
		if ($this->hasArgument('then')) {
			return $this->arguments['then'];
		}
		foreach ($this->childNodes as $childNode) {
			if ($childNode instanceof Tx_Fluid_Core_Parser_SyntaxTree_ViewHelperNode
				&& $childNode->getViewHelperClassName() === 'Tx_Fluid_ViewHelpers_ThenViewHelper') {
				$data = $childNode->evaluate($this->getRenderingContext());
				return $data;
			}
		}
		return $this->renderChildren();
	}*/

	/**
	 * Returns value of "else" attribute.
	 * If else attribute is not set, iterates through child nodes and renders ElseViewHelper.
	 * If else attribute is not set and no ElseViewHelper is found, an empty string will be returned.
	 *
	 * @return string rendered ElseViewHelper or an empty string if no ThenViewHelper was found
	 */
	/*protected function renderElseChild() {
		foreach ($this->childNodes as $childNode) {
			if ($childNode instanceof Tx_Fluid_Core_Parser_SyntaxTree_ViewHelperNode
				&& $childNode->getViewHelperClassName() === 'Tx_Fluid_ViewHelpers_ElseViewHelper') {
				return $childNode->evaluate($this->getRenderingContext());
			}
		}
		if ($this->hasArgument('else')) {
			return $this->arguments['else'];
		}
		return '';
	}
	
	protected function renderNotLoggedInChild() {
			
		return "c ".count($this->childNodes);
		
		foreach ($this->childNodes as $childNode) {
				
			return 	'a'.$childNode->getViewHelperClassName();
			
			if ($childNode instanceof Tx_Fluid_Core_Parser_SyntaxTree_ViewHelperNode
				&& $childNode->getViewHelperClassName() === 'Tx_Wpj_ViewHelpers_NotLoggedInViewHelper') {
				return $childNode->evaluate($this->renderingContext);
			}
		}

		if (count($this->childNodes) == 0) return 'Missing if-/then-childnodes.'; 
		return '';
		
	}*/
	
	/**
	 * renders <f:then> child if , otherwise renders <f:else> child.
	 *
	 * @param integer $minLevel 
	 * @return string the rendered string
	 */
	public function render($minLevel) {
		if ($GLOBALS['TSFE']->loginUser){
			// loggedIn
			if ( (int)$GLOBALS["TSFE"]->fe_user->user['tx_wpj_admin'] >= (int)$minLevel) {
				return $this->renderThenChild();
			} else {
				return $this->renderElseChild();
			}
		}
		return '';
		
	}
	
}
?>