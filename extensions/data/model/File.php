<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\extensions\data\model;

use \Iterator;

/**
 * `FileRecord` is an alternative to the `model\RecordSet` class, which is optimized for organizing
 * collections of records from the file system. `FileRecord`
 *
 */
class File extends \lithium\data\model\Record {

	/**
	 * Creates a new record object with default values.
	 *
	 * Options defined:
	 * - 'data' _array_: Data to enter into the record. Defaults to an empty array.
	 * - 'model' _string_: Class name that provides the data-source for this record.
	 *   Defaults to `null`.
	 *
	 * @param array $config
	 * @return object Record object.
	 */
	public function __construct($config = array()) {
		$defaults = array('model' => null, 'data' => array());
		if (!is_array($config['data'])) {
			$config['data'] = array($config['data']);
		}
		parent::__construct((array) $config + $defaults);
	}
	
	
	protected function _init() {
		parent::_init();
	}
	
	public function __set($name, $value) {
		if ($name == 'data' && is_object($value)) {
			$this->_data[0] = $value;
			return;
		}
		$this->_modified[$name] = true;
		$this->_data[$name] = $value;
	}
	
	public function __call($method, $params = array()) {
		if (isset($this->_data[0]) && is_object($this->_data[0])) {
			if (method_exists($this->_data[0], $method)) {
				return call_user_func_array(array($this->_data[0], $method), $params);
			}
		}
		return parent::__call($method, $params);
	}
	
	public function contents() {
		$file = null;
		if (isset($this->_data[0]) && is_object($this->_data[0])) {
			$file = $this->_data[0]->getPathname();
		}
		if (!file_exists($file)) {
			return false;
		}
		return file_get_contents($file);
	}
}

?>