<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
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
 */
class Tx_Wpj_ViewHelpers_Form_UploadViewHelper extends Tx_Fluid_ViewHelpers_Form_UploadViewHelper {

	/**
	 * Renders some tags to view, upload and delete an image
	 *
	 * @return string
	 */
	public function render() {
		$name = $this->getName();
		$this->registerFieldNameForFormTokenGeneration($name);
		
		// hidden field for triggering set-method
		$this->tag->addAttribute('type', 'hidden');
		$this->tag->addAttribute('name', $name);
		$hiddentag = $this->tag->render();
		
		// upload field 
		$this->tag->addAttribute('type', 'file');
		$this->tag->addAttribute('name', $name."[file]");
		$this->setErrorClassAttribute();
		$filetag = $this->tag->render();
		
		// image
		$value = $this->getValue();
		if (strlen($value) > 20) {
			// image assigned
			$image = '<img src="data:image/gif;base64,'.$value.'" alt="" height="100px" style="border:1px solid #ddd;"/>';
			$this->tag->addAttribute('type', 'checkbox');
			$this->tag->addAttribute('value', 'delete');
			$this->tag->addAttribute('name', $name."[delete]");
			$deleteImage = $this->tag->render()." Bild entfernen \n";
		}
		
		// collect fields
		$output = $hiddentag."\n";
		$output .= $filetag."<br/>\n";
		$output .= $image."\n";
		$output .= $deleteImage."\n";
		
		return $output;
	}
}


?>
