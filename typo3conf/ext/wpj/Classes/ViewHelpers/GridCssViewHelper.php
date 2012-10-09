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
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package WPJ
 *
 */
class Tx_Wpj_ViewHelpers_GridCssViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Renders slot divs for layout grid
	 *
	 * @param integer $i 
	 * @return string the rendered string
	 */
	public function render($i) {
		$c = ($i["index"]%3) * 2;
		$output = "";
		// start row? (contains 3 items)
		if ((($i["cycle"]+2)%3)==0) $output .= '<div class="row">';
		// start wrap
		$output .= '<div class="slot-'.($c).'-'.($c+1).'">';
		$output .= $this->renderChildren();
		// finish wrap
		$output .= '</div>';
		// finish row?
		if ($i["cycle"]%3==0 || $i["last"]) $output .= '</div>';
		return $output;
	}
	
}
?>