<?php
/***************************************************************
*  Copyright notice
*
*  (c) 
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
 * 
 */
class Tx_Wpj_Utility_ThumbProcessing {
	/**
     * @var tslib_cObj
     */
    protected $contentObject;
      
     /**
     * @var t3lib_fe contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
     */
    protected $tsfeBackup;

    
    
     /**
     * Render the img source for a thumbnail
     * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
     *
     * @param string $src
     * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param integer $minWidth minimum width of the image
     * @param integer $minHeight minimum height of the image
     * @param integer $maxWidth maximum width of the image
     * @param integer $maxHeight maximum height of the image
     *
     * @return string rendered tag.
     */
    public function getThumb($src, $width = 100, $height = 100, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL) {
        $this->contentObject = new tslib_cObj();
        
        $setup = array(
            'width' => $width,
            'height' => $height,
            'minW' => $minWidth,
            'minH' => $minHeight,
            'maxW' => $maxWidth,
            'maxH' => $maxHeight
        );
        $imageInfo = $this->contentObject->getImgResource($src, $setup);
        $GLOBALS['TSFE']->lastImageInfo = $imageInfo;
        if (!is_array($imageInfo)) {
            //exit('Could not get image resource for "' . htmlspecialchars($src) . '".');
            t3lib_div::sysLog('[tx_wpj]: ' . 'Could not get image resource for "' . htmlspecialchars($src) . '".','tx_wpj',5);
 
        }
        
        $imageInfo[3] = t3lib_div::png_to_gif_by_imagemagick($imageInfo[3]);
        $GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];

        $imageSource = $GLOBALS['TSFE']->absRefPrefix . t3lib_div::rawUrlEncodeFP($imageInfo[3]);
        
        return $imageSource;
    }
		
        
        
        
    /**
     * Prepares $GLOBALS['TSFE'] for Backend mode
     * This somewhat hacky work around is currently needed because the getImgResource() function of tslib_cObj relies on those variables to be set
     *
     * @return void
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    protected function simulateFrontendEnvironment() {
        $this->tsfeBackup = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : NULL;
            // set the working directory to the site root
        $this->workingDirectoryBackup = getcwd();
        chdir(PATH_site);

        $typoScriptSetup = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $GLOBALS['TSFE'] = new stdClass();
        $template = t3lib_div::makeInstance('t3lib_TStemplate');
        $template->tt_track = 0;
        $template->init();
        $template->getFileName_backPath = PATH_site;
        $GLOBALS['TSFE']->tmpl = $template;
        $GLOBALS['TSFE']->tmpl->setup = $typoScriptSetup;
        $GLOBALS['TSFE']->config = $typoScriptSetup;
    }

    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @return void
     * @author Bastian Waidelich <bastian@typo3.org>
     * @see simulateFrontendEnvironment()
     */
    protected function resetFrontendEnvironment() {
        $GLOBALS['TSFE'] = $this->tsfeBackup;
        chdir($this->workingDirectoryBackup);
    }
}

?>