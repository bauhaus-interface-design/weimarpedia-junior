<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
*           
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
 * Class implements some static methods for image processing
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage ImageProcessing
 */
class Tx_Wpjr_Utility_ImageProcessing {
	
    /**
     * Resizes an image to the given values
     * 
     * @param   int     $width   The maximum image width
     * @param   int     $height  The maximum image height
     * @param   string  $source  The source file
     * @param   string  $target  The target file
     * @return  void
     */
    public static function resizeImage($width, $height, $quality, $source, $target, $imageType='jpg') {
    	
    	$basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions');
    	$sourceJpg = $source.".".$imageType;
    	t3lib_div::upload_copy_move( $source, $sourceJpg );
		
    	// check for source file to be existing
    	if (!file_exists($sourceJpg)) {
    		exit('no image');
    		throw new Exception('Source for image conversion does not exist ' . $sourceJpg . ' 1293395741');
    	}
    	
        if (self::isImageMagickInstalled()) {
            
           	$stdGraphic = self::getStdGraphicObject();
            $info = $stdGraphic->getImageDimensions($sourceJpg);
            //print_r($sourceJpg." - info: "); var_dump($info);print_r('<br/>');
            $options = array();
            $options["minH"] = $height;
            $options["minW"] = $width;
            //print_r("options: "); print_r($options);print_r('<br/>');
            $data = $stdGraphic->getImageScale($info, $width."cm", $height."cm", $options);   
            $offsetX = intval(($data[0] - $data['origW']) * ($data['cropH'] + 100) / 200);
			$offsetY = intval(($data[1] - $data['origH']) * ($data['cropV'] + 100) / 200); 
            $params = '-geometry '.$data[0].'x'.$data[1].'! ';
            $params .= "-crop ". $width."x".$height."+$offsetX+$offsetY -quality ".$quality;
            $params .= " -auto-orient";
			
            $imageMagickCommandString =  $params.' "'.$sourceJpg.'" "'.$target.'"';
            $cmd = t3lib_div::imageMagickCommand('convert',$imageMagickCommandString);
            $im = array();
            $im["string"] = $cmd;
            $im["error"] = shell_exec($cmd.' 2>&1');
            ///print_r();var_dump($im); exit();
            unlink($sourceJpg);
            return $im;
			
        } else {
        	throw new Exception('IM not installed.');
//        	
//            // Get new dimensions
//            list($width_orig, $height_orig) = getimagesize($source);
//            
//            if ($width && ($width_orig < $height_orig)) {
//               $width = ($height / $height_orig) * $width_orig;
//            } else {
//               $height = ($width / $width_orig) * $height_orig;
//            }
//            
//            // Resample
//            $image_p = imagecreatetruecolor($width, $height);
//            $image = imagecreatefromjpeg($source);
//            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//            
//            // Output
//            imagejpeg($image_p, $target, $quality);
//            
        }
        
    }

    
    /**
     * Returns 
     *
     * @return string
     */
    public function getResizedBase64($source, $w, $h, $quality, $imageType='jpg') {
    	$imageType = substr($imageType, -3, 3);
    	$resizedImageFile = $source."_resized";
		$this->resizeImage($w, $h, $quality, $source, $resizedImageFile, $imageType);
		$rawImage = base64_encode(file_get_contents($resizedImageFile));
		unlink($resizedImageFile);
    	return $rawImage;
    }
    
    
    /**
     * Returns instance of standard typo3 graphics object
     *
     * @return t3lib_stdGraphic
     */
    public function getStdGraphicObject() {
    	return t3lib_div::makeInstance("t3lib_stdGraphic");
    }
    
    
    
    /**
     * Returns instance of Typo3 standard graphics object
     * @return t3lib_stdgraphic
     */
    public static function getGfxObject() {
    	return t3lib_div::makeInstance("t3lib_stdgraphic");
    }
    
    
    
    /**
     * Returns true, if Image Magick is installed on this typo3 installation
     *
     * @return boolean  True, if Image Magick is installed
     */
    public static function isImageMagickInstalled() {
    	return ($GLOBALS['TYPO3_CONF_VARS']['GFX']['im'] == 1);
    }
	
    
    
      
    
    
    /**
     * 
     * @params string $name e.g. image
     * @return 
     */
    public function processImage($name, $model, $prefix, $width, $height, $quality) {
    
		// delete?
		if ($_POST[$prefix][$model][$name]['delete'] == 'delete') {
			return "";
		}
		
		$newModel = 'new'.ucfirst($model);
		
		if ($_FILES[$prefix]){
			$tmpFile = (count($_FILES[$prefix]['tmp_name'][$model]) > 0) ? $_FILES[$prefix]['tmp_name'][$model][$name]['file'] : $_FILES[$prefix]['tmp_name'][$newModel][$name]['file'];
			$tmpMimeType = (count($_FILES[$prefix]['type'][$model]) > 0) ? $_FILES[$prefix]['type'][$model][$name]['file'] : $_FILES[$prefix]['type'][$newModel][$name]['file'];
			
			switch($tmpMimeType){
				case "image/png": $fileType = 'png';break;
				case "image/gif": $fileType = 'gif';break;
				default: $fileType = 'jpg';
			}
			
			if (!empty($tmpFile)) {
				return $this->getResizedBase64($tmpFile, $width, $height, $quality, $fileType);
			}
		}
		return NULL;
    }	
		
		
}

?>