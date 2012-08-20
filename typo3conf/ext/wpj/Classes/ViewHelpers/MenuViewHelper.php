<?php
/*                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 *
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Wpj_ViewHelpers_MenuViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Initialize arguments
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
	}

	/**
	 * Render 
	 *
	 * @param string $action
	 * @param string $controller
	 * @param string $selection
	 * @param string $wrap
	 * @param string $classIfActive
	 * @param string $customclass
	 * @param string $controllerArguments
	 * @return string 
	 */
	public function render($action = NULL, $controller = NULL, $selection = NULL, $wrap = 'li', $classIfActive = 'current', $customclass = '', $controllerArguments = '') {
		// build link
		parse_str($controllerArguments, $controllerArgs);
		
		if ($selection != NULL) $controllerArgs = array_merge(array('selection' => $selection), $controllerArgs);
		
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder
			->reset()
			->uriFor($action, $controllerArgs, $controller);
		$this->tag = new Tx_Fluid_Core_ViewHelper_TagBuilder("a", $this->renderChildren());
		$this->tag->addAttribute('href', $uri, true);
		$link = $this->tag->render();
		
		// check if active
		$request_controller = $this->controllerContext->getRequest()->getControllerName();
		$request_action = $this->controllerContext->getRequest()->getControllerActionName();
		$request_selection = ($this->controllerContext->getRequest()->hasArgument('selection'))? $this->controllerContext->getRequest()->getArgument('selection') : NULL;
		
		if ($action == NULL) $action = $request_action;
		if ($controller == NULL) $controller = $request_controller;		
		
		$active = ( ($action == $request_action) && ($controller == $request_controller) && ($selection == $request_selection) );
		
		// build wrap
		$this->tag = new Tx_Fluid_Core_ViewHelper_TagBuilder($wrap, $link);
		if ($active) $customclass .= ' '.$classIfActive;
		$this->tag->addAttribute('class', $customclass, true);
		// output
		return $this->tag->render();
		
	}
}


?>