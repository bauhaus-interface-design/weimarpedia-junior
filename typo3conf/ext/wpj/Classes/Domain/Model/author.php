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
 * Persons or Groups, who manage articles
 *
 * @package WPJ
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Wpj_Domain_Model_author extends Tx_Extbase_Domain_Model_FrontendUser {
	
	/**
	 * @var integer
	 */
	protected $disable;

    /**
     * @var integer
     */
    protected $admin;

    /**
     * @var DateTime
     */
    protected $starttime;

    /**
     * @var DateTime
	 * is always 0 - expired usernames are otherwise not available for linked objects
     */
    protected $endtime;
	
    /**
     * @var DateTime
	 * contains the endtime 
	 * used in session controller as custom implementation
     */
    protected $wpj_endtime;
    
    /**
     * @var Tx_Wpj_Domain_Model_school
     */
    protected $school;
    
    /**
	 * path to avatar directory
     * 
	 * @var string
	 */
	protected $AVATAR_DIR = 'uploads/wpj/avatars';

	
	/**
     * Sets the admin level
     * 0..9 students
     * 10..49 teacher
     * 50.. admins
     *
     * @param integer $adminlevel
     * @return void
     */
    public function setAdmin($adminlevel) {
        $this->admin = $adminlevel;
    }

    /**
     * Returns the admin level
     *
     * @return integer
     */
    public function getAdmin() {
        return $this->admin;
    }
	
    /**
     * Returns the short name
     *
     * @return String
     */
    public function getShortName() {
    	$shortName = $this->getName();
    	if (empty($shortName)) $shortName = $this->getUserName();
        return $shortName;
    }   
    
    /**
     * Returns path to avatar image for e.g. image helper
     * e.g.: uploads/wpj/avatars/6.jpg
     * 
     * @return String
     */
    public function getAvatarImage() {
    	$avatar = $this->getUid() . ".jpg";
    	if ( file_exists($this->getAvatarAbsPath() . "/" . $avatar) ) return $this->AVATAR_DIR."/".$avatar;
        else return 'typo3conf/ext/wpj/Resources/Public/img/weimarpedia_platzhalter_logo.gif';
    } 
    
    /**
     * Returns absolute system path to avatar directory
     * e.g.: /opt/local/apache/htdocs/.../wpj_typo3/uploads/wpj/avatars/6.jpg
     * 
     * @return String
     */
    public function getAvatarAbsPath() {
    	$basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions');
		$path = t3lib_div::getFileAbsFileName($this->AVATAR_DIR);
    	return $path;
    } 
    
    
    /**
     * Returns disable
     *
     * @return boolean
     */
    public function getDisabled() {
        return ($this->disable!=1);
    }  
    
    /**
     * Returns starttime
     *
     * @return DateTime
     */
    public function getStarttime() {
        return $this->starttime;
    } 
    
    /**
     * Returns endtime
     * endtime is not used, because author objects become invalid after endtime
     * use wpj_endtime instead to check a valid login
     *
     * @return DateTime
     */
    public function getEndtime() {
        return $this->endtime;
    }
	
	/**
     * Returns wpj_endtime as end of a valid login
     *
     * @return DateTime
     */
    public function getWpjEndtime() {
        return $this->wpj_endtime;
	}
	
     /**
     * Returns true if a login is valid now
     *
     * @return Boolean
     */       
    public function getLoginIsValid() {
        $t = time();
    	return ( ($this->wpj_endtime == 0 && $this->starttime < $t) || ($this->starttime < $t || $this->wpj_endtime > $t) );
    } 
     
     /**
     * Returns true if a login is not valid now
     *
     * @return Boolean
     */       
    public function getLoginIsExpired() {
        return !$this->getLoginIsValid();
    } 
    
    /**
     * Sets school
     *
     * @param Tx_Wpj_Domain_Model_school $school
     * @return void
     */
    public function setSchool($school) {
        $this->school = $school;
    }

    /**
     * Returns school
     *
     * @return Tx_Wpj_Domain_Model_school
     */
    public function getSchool() {
        return $this->school;
    }
    
    /**
     * Returns a random password
     *
     * @return string
     */
    public function generatePassword($length = 8) {
	    $password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzCDFGHJKLMNPQRTVWXYZ%?#";
		$maxlength = strlen($possible);
	    $i = 0; 
	    
	    // add random characters to $password until $length is reached
	    while ($i < $length) { 
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);
	        $password .= $char;
			$i++;
	    }
		return $password;
	}
    
    /**
     * Returns random username 
     * format: 888-888
     *
     * @return string
     */
 	public function generateUsername($prefix='') {
 		$username = $prefix;
		$possible = "123467890";
		$maxlength = strlen($possible);
	    $length = 7; // 888-888
		$i = 0; 
	    while ($i < $length) {
	    	if ($i != 3){ 
				$char = substr($possible, mt_rand(0, $maxlength-1), 1);
		        $username .= $char;
	    	} else $username .= "-";
			$i++;
	    }
	    
	    // TODO: check if unique
	    
		return $username;
	}
	
    /**
     * Sets starttime and duration for login
     *
     * @return void
     */
	public function setStarttimeAndDuration($starttime, $duration) {
		$this->starttime = $starttime;
		$this->wpj_endtime = $starttime + $duration;
	}
	
}
?>