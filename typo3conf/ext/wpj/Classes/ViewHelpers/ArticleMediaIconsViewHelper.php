<?php

/**
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package WPJ
 *
 */
class Tx_Wpj_ViewHelpers_ArticleMediaIconsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Renders a 4-icon-box for the available media in an article
	 *
	 * @param string $article 
	 * @return string the rendered string
	 */
	public function render($article) {
		$output = "";
		
		// collect media types
		$medias = $article->getMedias();
		$medias->rewind();
		while ($media = $medias->current()){
			if ($media->getIsImage()) $image = " hasImage";
			if ($media->getIsAudio()) $audio = " hasAudio";
			if ($media->getIsVideo()) $video = " hasVideo";
			if ($media->getIsPdf()) $pdf = " hasPdf";
			$medias->next();
		}
		
		// render 4 icon-boxes
		$output .= '<div class="image'.$image.'"></div>';
		$output .= '<div class="audio'.$audio.'"></div>';
		$output .= '<div class="video'.$video.'"></div>';
		$output .= '<div class="pdf'.$pdf.'"></div>';
		return $output;
	}
	
}
?>