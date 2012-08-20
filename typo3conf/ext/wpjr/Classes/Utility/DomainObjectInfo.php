<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Claus Due <claus@wildside.dk>, Wildside A/S
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
 * DomainObjectInfo utility. Reads various meta-information about DomainObject
 * classes, such as related controller names, properties tagged by special
 * annotations, datatypes of properties (without reading data from an instance),
 * getting repository instances, determining plugin names and more.
 *
 *
 * @author Claus Due, Wildside A/S
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package Fed
 * @subpackage Utility
 */
class Tx_Wpjr_Utility_DomainObjectInfo implements t3lib_Singleton {

	/**
	 * RecursionHandler instance
	 * @var Tx_Wpjr_Utility_RecursionHandler
	 */
	public $recursionHandler;

	/**
	 * ReflectionService instance
	 * @var Tx_Extbase_Reflection_Service $service
	 */
	protected $reflectionService;

	/**
	 * ObjectManager instance
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManger;

	/**
	 * Inject a RecursionHandler instance
	 * @param Tx_Wpjr_Utility_RecursionHandler $handler
	 */
	public function injectRecursionHandler(Tx_Wpjr_Utility_RecursionHandler $handler) {
		$this->recursionHandler = $handler;
	}

	/**
	 * Inject a Reflection Service instance
	 * @param Tx_Extbase_Reflection_Server $service
	 */
	public function injectReflectionService(Tx_Extbase_Reflection_Service $service) {
		$this->reflectionService = $service;
	}

	/**
	 * Inject a Reflection Service instance
	 * @param Tx_Extbase_Object_ObjectManager $manager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $manager) {
		$this->objectManager = $manager;
	}

	/**
	 * Get an array of properties of $object which have been annotated with $annotation
	 * optionally restricting the return values by an additional annotation value
	 *
	 * @param mixed $object The object or classname containing properties
	 * @param string $annotation The name of the annotation to search for, for example 'ExtJS' for annotation @ExtJS (case sensitive)
	 * @param string $value The value to search for among annotation values. Defaults to TRUE which means the annotation must simply be present
	 * @param boolean $addUid If TRUE, the field "uid" will be force-added to the output regardless of annotation
	 * @return array
	 */
	public function getPropertiesByAnnotation($object, $annotation, $value=TRUE, $addUid=TRUE) {
		$propertyNames = array();
		$className = is_object($object) ? get_class($object) : $object;
		$this->recursionHandler->in();
		$this->recursionHandler->check($className);
		$properties = $this->reflectionService->getClassPropertyNames($className);
		foreach ($properties as $propertyName) {
			if ($this->hasAnnotation($className, $propertyName, $annotation, $value)) {
				array_push($propertyNames, $propertyName);
			}
		}
		if ($addUid) {
			array_push($propertyNames, 'uid');
		}
		return $propertyNames;
	}

	/**
	 * Resolve a controller name for $object
	 *
	 * @param mixed $object Instance or classname of Model object
	 * @return string
	 */
	public function getControllerName($object) {
		$className = is_object($object) ? get_class($object) : $object;
		return array_pop(explode('_', $className));
	}

	/**
	 * Resolve the name of the extension capable of handling this Model Object
	 *
	 * @param mixed $object Instance or classname of Model object
	 * @return string
	 */
	public function getExtensionName($object) {
		$className = is_object($object) ? get_class($object) : $object;
		$parts = explode('_', $className);
		array_shift($parts);
		return array_shift($parts);
	}

	/**
	 * Resolve a plugin name for this Model Object
	 *
	 * @param mixed $object Instance or classname of Model object
	 * @return string
	 */
	public function getPluginName($object) {
		$extensionName = $this->getExtensionName($object);
		$controllerName = $this->getControllerName($object);
		$pluginName = Tx_Extbase_Utility_Extension::getPluginNameByAction($extensionName, $controllerName, 'update');
		return $pluginName;
	}

	/**
	 * @param mixed $object  Instance or classname
	 */
	public function getRepositoryClassname($object) {
		$className = is_object($object) ? get_class($object) : $object;
		$name = str_replace('_Domain_Model_', '_Domain_Repository_', $className) . 'Repository';
		return $name;
	}

	/**
	 * Checks if $className->$propertyName is annotated w/ $annotation having $value
	 *
	 * @param mixed $className The name of the class containing the property. Can be an object instance
	 * @param string $propertyName The name of the property on className to check
	 * @param string $annotation The annotation which must be present
	 * @param string $value The value which annotation must contain - default is TRUE meaning annotation must simply be present
	 * @return boolean
	 */
	public function hasAnnotation($className, $propertyName, $annotation, $value=TRUE) {
		$className = is_object($className) ? get_class($className) : $className;
		$tags = $this->reflectionService->getPropertyTagsValues($className, $propertyName);
		$annotationValues = $tags[$annotation];
		if ($annotationValues !== NULL && (in_array($value, $annotationValues) || $value === TRUE)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Get data types of supplied properties - if no propertyNames specified gets
	 * all properties as "propertyName" => "dataType"
	 *
	 * @param mixed $object The object or classname containing the properties
	 * @param array $propertyNames Optional list of properties to get - if empty, gets all properties' types
	 */
	public function getPropertyTypes($object, array $propertyNames=NULL) {
		$className = is_object($object) ? get_class($object) : $object;
		$types = array();
		$properties = $this->reflectionService->getClassPropertyNames($className);
		foreach ($properties as $propertyName) {
			$types[$propertyName] = $this->getPropertyType($object, $propertyName);
		}
		return $types;
	}

	/**
	 * Get the type of a specific property on $object
	 *
	 * @param mixed $object DomainObject or classname of DomainObject
	 * @param string $propertyName
	 */
	public function getPropertyType($object, $propertyName) {
		$className = is_object($object) ? get_class($object) : $object;
		$tags = $this->reflectionService->getPropertyTagsValues($className, $propertyName);
		return array_shift(explode(' ', $tags['var'][0]));
	}

	/**
	 * Get an array of all $propertyName=>$tags
	 *
	 * @param mixed $object Instance of class from which to read property tags by annotation
	 * @param string $annotation  The annotation which the property must have
	 * @return array
	 */
	public function getAllTagsByAnnotation($object, $annotation) {
		$tagArray = array();
		$className = is_object($object) ? get_class($object) : $object;
		$properties = $this->reflectionService->getClassPropertyNames($className);
		foreach ($properties as $propertyName) {
			if ($this->hasAnnotation($className, $propertyName, $annotation)) {
				$tags = $this->reflectionService->getPropertyTagsValues($className, $propertyName);
				$set = $tags[$annotation];
			}
		}
		return $tagArray;
	}

	/**
	 * Returns an array of property names and values by searching the $object
	 * for annotations based on $annotation and $value. If $annotation is provided
	 * but $value is not, All properties which simply have the annotation present.
	 * Relational values which have the annotation are parsed through the same
	 * function - sub-elements' properties are exported based on the same
	 * annotation and value
	 *
	 * @param mixed $object The object or classname to read
	 * @param string $annotation The annotation on which to base output
	 * @param string $value The value to search for; multiple values may be used in the annotation; $value must be present among them. If TRUE, all properties which have the annotation are returned
	 * @param boolean $addUid If TRUE, the UID of the DomainObject will be force-added to the output regardless of annotation
	 * @return array
	 */
	public function getValuesByAnnotation($object, $annotation='json', $value=TRUE, $addUid=TRUE) {
		if (is_array($object)) {
			$array = array();
			foreach ($object as $k=>$v) {
				$array[$k] = $this->getValuesByAnnotation($v, $annotation, $value, $addUid);
			}
			return $array;
		}
		if (is_object($object)) {
			$className = get_class($object);
		} else {
			$className = $object;
			$object = $this->objectManger->get($className);
		}
		$this->recursionHandler->in();
		$this->recursionHandler->check($className);
		$properties = $this->reflectionService->getClassPropertyNames($className);
		$return = array();
		if ($addUid === TRUE) {
			$return['uid'] = $object->getUid();
		}
		foreach ($properties as $propertyName) {
			$getter = 'get' . ucfirst($propertyName);
			if (method_exists($object, $getter) === FALSE) {
				continue;
			}
			if ($this->hasAnnotation($className, $propertyName, $annotation, $value)) {
				$returnValue = $object->$getter();
				if ($returnValue instanceof Tx_Extbase_Persistence_ObjectStorage) {
					$array = $returnValue->toArray();
					foreach ($array as $k=>$v) {
						$array[$k] = $this->getValuesByAnnotation($v, $annotation, $value, $addUid);
					}
					$returnValue = $array;
				} else if ($returnValue instanceof Tx_Extbase_DomainObject_DomainObjectInterface) {
					$returnValue = $this->getValuesByAnnotation($returnValue, $annotation, $value, $addUid);
				} else if ($returnValue instanceof DateTime) {
					$returnValue = $returnValue->format('r');
				}
				$return[$propertyName] = $returnValue;
			}
		}
		$this->recursionHandler->out();
		return $return;
	}


}




?>