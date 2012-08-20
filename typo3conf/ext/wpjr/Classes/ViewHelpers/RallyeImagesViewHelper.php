<?php

class Tx_Wpjr_ViewHelpers_RallyeImagesViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * renders snipplet for viewing images within presentation 
	 *
	 * @param Tx_Wpjr_Domain_Model_Task $task 
	 * @return string the rendered string
	 */
	public function render($task) {
		
		if ($task->getImage1() == NULL) return "";
		else if ($task->getImage2() == NULL) $num_images = 1;
		else if ($task->getImage3() == NULL) $num_images = 2;
		else 
		$num_images = 3;
		
		$output = '<div class="img-indented img i'.$num_images.' clearfix">';
		for ($i=1;$i<=$num_images;$i++){
			$img = "getImage".$i;
			$output .= '<div class="image">';
			$output .= '<img src="data:image/jpg;base64,'.$task->$img().'" alt="" height="400px" style="border:1px solid #ddd;"/>';
			$output .= '</div>';
		}				
		$output .= '</div>';
		
		return $output;
	}
	
}
?>