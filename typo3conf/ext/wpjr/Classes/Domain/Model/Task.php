<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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
 * Task
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Wpjr_Domain_Model_Task extends Tx_Extbase_DomainObject_AbstractEntity {

	
	/**
	 * @var integer
	 */
	protected $IMG_WIDTH = 600;
	
	/**
	 * @var integer
	 */
	protected $IMG_HEIGHT = 450;
	
	/**
	 * @var integer
	 */
	protected $IMG_QUALITY = 70;
	
	/**
	 * @var array
	 */
	protected static $RESULT_TYPES = array(
		'1' => array(
			'label' => 'Text',
			'result' => 'text',
			'options' => array(
				'maxChars' => 160	
				) 
			),
			
		'3' => array(
			'label' => '1 Photo mit der Kamera',
			'result' => 'photo',
			'options' => array(
				'quantity' => 1	
				) 
			),
			
			
		'5' => array(
			'label' => 'Teilnehmername eingeben',
			'result' => 'username',
			'options' => array(
				
				) 
			),
			
		'6' => array(
			'label' => 'Teilnehmerfoto',
			'result' => 'userphoto',
			'options' => array(
				
				) 
			),
			
//		'7' => array(
//			'label' => 'Richtige Zuordnung von Begriffen',
//			'result' => 'assignment',
//			'options' => array(
//				
//				) 
//			),
			
//		'5' => array(
//			'label' => 'Richtige Zuordnung von Begriffen',
//			'result' => 'assignment',
//			'options' => array(
//				
//				) 
//			),

			
			
			
		'0' => array(
			'label' => '',
			'result' => '',
			'options' => ''
			)
		
	);
	
	
	
	
	/**
	 * parent
	 *
	 * @var integer $parent
	 * @json
	 */
	protected $parent;

	/**
	 * sorting
	 *
	 * @var integer $sorting
	 */
	protected $sorting;

	/**
	 * title
	 *
	 * @var string $title
	 * @json
	 */
	protected $title;

	/**
	 * intro
	 *
	 * @var string $intro
	 * @json
	 */
	protected $intro;

	/**
	 * instruction
	 * 
	 * @var string $instruction
	 * @json
	 */
	protected $instruction;

	/**
	 * image1
	 *
	 * @var string $image1
	 * @json
	 */
	protected $image1;

	/**
	 * image2
	 *
	 * @var string $image2
	 * @json
	 */
	protected $image2;

	/**
	 * image3
	 *
	 * @var string $image3
	 * @json
	 */
	protected $image3;

	/**
	 * image4
	 *
	 * @var string $image4
	 * @json
	 */
	protected $image4;

	/**
	 * duration
	 *
	 * @var integer $duration
	 */
	protected $duration;

	/**
	 * resulttype
	 *
	 * @var string $resulttype
	 * @json
	 */
	protected $resulttype;

	/**
	 * resultoptions
	 *
	 * @var string $resultoptions
	 * @json
	 */
	protected $resultoptions;

	/**
	 * resultrequired
	 *
	 * @var integer $resultrequired
	 * @json
	 */
	protected $resultrequired;

	/**
	 * rallye
	 *
	 * @var Tx_Wpjr_Domain_Model_Rallye $rallye
	 */
	protected $rallye;

	/**
	 * place
	 *
	 * @var Tx_Wpjr_Domain_Model_RallyePlace
	 * 
	 */
	protected $place;


	
	/**
	 * The constructor.
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Setter for parent
	 *
	 * @param integer $parent parent
	 * @return void
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}

	/**
	 * Getter for parent
	 *
	 * @return integer parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Setter for sorting
	 *
	 * @param integer $sorting sorting
	 * @return void
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}

	/**
	 * Getter for sorting
	 *
	 * @return integer sorting
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for intro
	 *
	 * @param string $intro intro
	 * @return void
	 */
	public function setIntro($intro) {
		$this->intro = $intro;
	}

	/**
	 * Getter for intro
	 *
	 * @return string intro
	 */
	public function getIntro() {
		return $this->intro;
	}

	/**
	 * Setter for instruction
	 *
	 * @param string $instruction instruction
	 * @return void
	 */
	public function setInstruction($instruction) {
		$this->instruction = $instruction;
	}

	/**
	 * Getter for instruction
	 *
	 * @return string instruction
	 */
	public function getInstruction() {
		return $this->instruction;
	}

	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Setter for image1
	 *
	 * @param string $image1 image1
	 * @return void
	 */
	public function setImage1($image1) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image1", "task", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
		if (!is_null($image)) $this->image1 = $image;
	}

	/**
	 * Getter for image1
	 *
	 * @return string image1
	 */
	public function getImage1() {
		return $this->image1;
	}

	/**
	 * Setter for image2
	 *
	 * @param string $image2 image2
	 * @return void
	 */
	public function setImage2($image2) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image2", "task", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
		if (!is_null($image)) $this->image2 = $image;
	}

	/**
	 * Getter for image2
	 *
	 * @return string image2
	 */
	public function getImage2() {
		return $this->image2;
	}

	/**
	 * Setter for image3
	 *
	 * @param string $image3 image3
	 * @return void
	 */		
	public function setImage3($image3) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image3", "task", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
		if (!is_null($image)) $this->image3 = $image;
	}

	/**
	 * Getter for image3
	 *
	 * @return string image3
	 */
	public function getImage3() {
		return $this->image3;
	}

	/**
	 * Setter for image4
	 *
	 * @param string $image4 image4
	 * @return void
	 */
	public function setImage4($image4) {
		$imageProcessor = t3lib_div::makeInstance('Tx_Wpjr_Utility_ImageProcessing');
		$image = $imageProcessor->processImage("image4", "task", "tx_wpjr_pi1", $this->IMG_WIDTH, $this->IMG_HEIGHT, $this->IMG_QUALITY);
		if (!is_null($image)) $this->image4 = $image;
	}

	/**
	 * Getter for image4
	 *
	 * @return string image4
	 */
	public function getImage4() {
		return $this->image4;
	}

	/**
	 * Setter for duration
	 *
	 * @param integer $duration duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}

	/**
	 * Getter for duration
	 *
	 * @return integer duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Setter for resulttype
	 *
	 * @param string $resulttype resulttype
	 * @return void
	 */
	public function setResulttype($resulttype) {
		$this->resulttype = $resulttype;// self::$RESULT_TYPES[$resulttype]['result'];
		$this->resultoptions = json_encode(  $this->getResultTypesOption($resultType) );
	}

	/**
	 * Getter for resulttype
	 *
	 * @return string resulttype
	 */
	public function getResulttype() {
		return $this->resulttype;
	}
	public function getIsText() {
		return ($this->resulttype == 'text')? true : false;
	}
	public function getIsPhoto() {
		return ($this->resulttype == 'photo')? true : false;
	}
	
	

	/**
	 * Setter for resultoptions
	 *
	 * @param string $resultoptions resultoptions
	 * @return void
	 */
	public function setResultoptions($resultoptions) {
		$this->resultoptions = $resultoptions;
	}

	/**
	 * Getter for resultoptions
	 *
	 * @return string resultoptions
	 */
	public function getResultoptions() {
		return $this->resultoptions;
	}

	/**
	 * Setter for resultrequired
	 *
	 * @param integer $resultrequired resultrequired
	 * @return void
	 */
	public function setResultrequired($resultrequired) {
		$this->resultrequired = $resultrequired;
	}

	/**
	 * Getter for resultrequired
	 *
	 * @return integer resultrequired
	 */
	public function getResultrequired() {
		return $this->resultrequired;
	}

	/**
	 * Setter for rallye
	 *
	 * @param Tx_Wpjr_Domain_Model_Rallye $rallye rallye
	 * @return void
	 */
	public function setRallye(Tx_Wpjr_Domain_Model_Rallye $rallye) {
		$this->rallye = $rallye;
	}

	/**
	 * Getter for rallye
	 *
	 * @return Tx_Wpjr_Domain_Model_Rallye rallye
	 */
	public function getRallye() {
		return $this->rallye;
	}


	/**
	 * Setter for place
	 *
	 * @param Tx_Wpjr_Domain_Model_RallyePlace
	 * @return void
	 */
	public function setPlace(Tx_Wpjr_Domain_Model_RallyePlace $place) {
		$this->place = $place;
	}
	public function removePlace() {
		$this->place = $place;
	}
	/**
	 * Getter for place
	 *
	 * @return Tx_Wpjr_Domain_Model_RallyePlace
	 */
	public function getPlace() {
		return $this->place;
	}

	
	public static function getResultTypesOptions() {
		$options = array();
		foreach (self::$RESULT_TYPES as $key => $value){
			$options[$value['result']] = $value['label'];
		}
		return $options;
	}
	
	public function getResultTypesOption($resultType) {
		foreach (self::$RESULT_TYPES as $key => $value){
			if ($value['result'] == $resultType) return $value['options'];
			
		}
		return NULL;
	}
	
	public function getResultTypeLabel() {
		foreach (self::$RESULT_TYPES as $key => $value){
			if ($value['result'] == $this->resulttype) return $value['label'];
			
		}
		return $this->resulttype;
	}
	
	
}
?>