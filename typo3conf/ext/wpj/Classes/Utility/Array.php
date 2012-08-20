<?php
/***************************************************************
*  Copyright notice
*
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
 * Class implements some static methods 
 * 
 * @author 
 * @package 
 */

class Tx_Wpj_Utility_Array {
	/**
	 * Tx_Extbase_Persistence_ObjectStorage
	 *
	 * @return array
	 */
	static public function collectIf($storage, $key, $value){
		$newStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$getter = 'get'.ucfirst($key);
		$storage->rewind();
		while ($storage->current()){
			$c = $storage->current();
			$a = $c->$getter();
			
			if ( 
				(gettype($a)!='object' && $a == $value) || 
				(gettype($a)=='object' && gettype($value)=='integer' && $a->getUid() == $value) 
				) $newStorage->attach($c);
			$storage->next();
		}
		return $newStorage;
	}
	
/**
	 * Tx_Extbase_Persistence_ObjectStorage
	 *
	 * @return array
	 */
	static public function collectIfNot($storage, $key, $value){
		$newStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$getter = 'get'.ucfirst($key);
		$storage->rewind();
		while ($storage->current()){
			$c = $storage->current();
			$a = $c->$getter();
			
			if ( 
				(gettype($a)!='object' && $a != $value) || 
				(gettype($a)=='object' && gettype($value)=='integer' && $a->getUid() != $value) 
				) $newStorage->attach($c);
			$storage->next();
		}
		return $newStorage;
	}
	
}