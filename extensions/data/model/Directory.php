<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\extensions\data\model;

/**
 * `FileRecord` is an alternative to the `model\RecordSet` class, which is optimized for organizing
 * collections of records from the file system. `FileRecord`
 *
 */
class Directory extends \lithium\data\collection\RecordSet {

	/**
	 * Magic method for passing some methods through to SplFileInfo type object
	 *
	 * @param string $method
	 * @param string $params
	 * @return void
	 */
	public function __call($method, $params = array()) {
		if (isset($this->_items[0]) && is_object($this->_items[0])) {
			if (method_exists($this->_items[0], $method)) {
				return call_user_func_array(array($this->_items[0], $method), $params);
			}
		}
	}

	/**
	* Returns the currently pointed to record in the set.
	*
	* @return `Record`
	*/
	public function current() {
		return $this->offsetGet($this->_pointer);
	}

	/**
	 * Lazy-loads records from a query using a reference to a database adapter and a query
	 * result resource.
	 *
	 * @param array $data
	 * @param mixed $key
	 * @return array
	 */
	protected function _populate($data = null, $key = null) {
		if ($this->_closed()) {
			return;
		}
		$data = $data ?: $this->_handle->result('next', $this->_result, $this);

		if (!isset($data)) {
			return $this->_close();
		}
		$this->_items[] = new $this->_classes['record'](compact('data'));
		$this->_index[] = $key;
		return $this->_items[$key];
	}
}

?>