<?php

class Tx_Wpj_ViewHelpers_GridCssViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * renders 
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