<?php

class Tx_Wpj_ViewHelpers_SelectViewHelper extends Tx_Fluid_ViewHelpers_Form_SelectViewHelper {
	/**
	 * Überschreibt die Methode aus dem Fluid-ViewHelper. Es wird geprüft, ob es in dem Option-Objekt eine Methode getChildren() gibt.
	 * Diese sollte Kind-Objekte aus dem Kategoriebaum zurückgeben. Werden Kind-Objekte gefunden, wird eine Option Group
	 *  gerendert, ansonsten die ganz normalen Option-Tags.
	 */
	protected function renderOptionTags($options) {
		$output = '';
		foreach ($options as $value => $option) {
			$children = array();
			if(method_exists($option, 'getChildren') && is_callable(array($option, 'getChildren'))) {
				$children = $option->getChildren();
			}
			if(!empty($children)) {
				$output .= $this->renderOptionGroupTag($this->getLabel($option), $children);
			} else {
				$value = $option->getUid();
				$isSelected = $this->isSelected($value);
				$output.= $this->renderOptionTag($value, $this->getLabel($option), $isSelected) . chr(10);
			}
		}
		return $output;
	}
 
	/**
	 * Auch hier muss eine Methode aus der Fluid-Klasse überschrieben werden, um nicht beim auslesen der Options
	 * die Objekte zu verlieren. Im Fluid-ViewHelper werden an dieser Stelle aus den Objekten bereits Strings gemacht.
	 * Das muss verhindert werden!
	 */
	protected function getOptions() {
		if (!is_array($this->arguments['options']) && !($this->arguments['options'] instanceof Traversable)) {
			return array();
		}
		$options = array();
		foreach ($this->arguments['options'] as $key => $value) {
			if (is_object($value)) {
				if ($this->hasArgument('optionValueField')) {
					$key = Tx_Extbase_Reflection_ObjectAccess::getProperty($value, $this->arguments['optionValueField']);
					if (is_object($key)) {
						if (method_exists($key, '__toString')) {
							$key = (string)$key;
						} else {
							throw new Tx_Fluid_Core_ViewHelper_Exception('Identifying value for object of class "' . get_class($value) . '" was an object.' , 1247827428);
						}
					}
				} elseif ($this->persistenceManager->getBackend()->getIdentifierByObject($value) !== NULL) {
					$key = $this->persistenceManager->getBackend()->getIdentifierByObject($value);
				} elseif (method_exists($value, '__toString')) {
					$key = (string)$value;
				} else {
					throw new Tx_Fluid_Core_ViewHelper_Exception('No identifying value for object of class "' . get_class($value) . '" found.' , 1247826696);
				}
			}
			$options[$key] = $value;
		}
		if ($this->arguments['sortByOptionLabel']) {
			asort($options);
		}
		return $options;
	}
 
	/**
	 * eine eigene Methode, um aus den Option-Objekten ein String-Label zu holen.
	 */
	protected function getLabel($option) {
		$label = '';
		if ($this->hasArgument('optionLabelField')) {
			$label = Tx_Extbase_Reflection_ObjectAccess::getProperty($option, $this->arguments['optionLabelField']);
			if (is_object($label)) {
				if (method_exists($label, '__toString')) {
					$label = (string)$label;
				} else {
					throw new Tx_Fluid_Core_ViewHelper_Exception('Label value for object of class "' . get_class($label) . '" was an object without a __toString() method.' , 1247827553);
				}
			}
		} elseif (method_exists($option, '__toString')) {
			$label = (string)$option;
		} elseif ($this->persistenceManager->getBackend()->getIdentifierByObject($option) !== NULL) {
			$label = $this->persistenceManager->getBackend()->getIdentifierByObject($option);
		}
		return $label;
	}
 
	/**
	 * Diese Methode rendert ein optgroup-Tag mit untergeordneten Kind-Optionen 
	 */
	protected function renderOptionGroupTag($label, $options) {
		return '<optgroup label="' . htmlspecialchars($label) . '">' . $this->renderOptionTags($options) . '</optgroup>';
	}
}
?>