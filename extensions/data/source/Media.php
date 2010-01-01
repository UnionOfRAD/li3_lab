<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\extensions\data\source;

use \ArrayIterator;
use \SplFileInfo;
use \lithium\core\Libraries;

/**
 * Data source for managing files
 *
 */
class Media extends \lithium\data\Source {

	/**
	 * increment value of current result set loop
	 * used by `result` to handle rows of json responses
	 *
	 * @var string
	 */
	protected $_iterator = 0;

	/**
	 * the full path to the directory that stores media
	 *
	 * @var string
	 */
	protected $_path = null;

	/**
	 * Class dependencies
	 *
	 * @var array
	 */
	protected $_classes = array(
		'record' => '\li3_lab\extensions\data\model\File',
		'recordSet' => '\li3_lab\extensions\data\model\Directory',
		'recordObject' => '\SplFileInfo',
	);

	/**
	 * Constructor for setting config options.
	 *
	 * @param string $config
	 */
	public function __construct($config = array()) {
		$defaults = array(
			'library' => 'app',
			'path' => 'resources',
			'mode' => 0755
		);
		parent::__construct((array) $config + $defaults);
	}

	/**
	 * Magic method does nothing yet
	 *
	 * @param string $method
	 * @param string $params
	 * @return void
	 */
	public function __call($method, $params) {}

	/**
	 * Check if the resource path exists
	 *
	 * @return void
	 */
	public function connect() {
		if (!$this->_isConnected) {
			$library = Libraries::get($this->_config['library']);
			$this->_path = "{$library['path']}{$this->_config['path']}";

			if (is_dir($this->_path)) {
				$this->_isConnected = true;
			}
		}
		return $this->_isConnected;
	}

	/**
	 * Disconnect does nothing
	 *
	 * @return void
	 */
	public function disconnect() {
		return true;
	}

	/**
	 * Used to configure model with data source specific settings
	 *
	 * @param string $class
	 * @return array
	 */
	public function configureClass($class) {
		return array('meta' => array('key' => 'name'), 'classes' => $this->_classes);
	}

	/**
	 * Lists all the directories in the resource
	 *
	 * @param $class string
	 * @return array
	 */
	public function entities($class = null) {
		return array_map('basename', glob($this->_path . '/*', GLOB_ONLYDIR));
	}

	public function describe($entity, $meta = array()) {
		$path = $this->_path;
		$full = "{$path}/{$entity}";
		$result = false;
		if (is_dir($full)) {
			$result = true;
		}
		if (!$result && mkdir($full, $this->_config['mode'], true)) {
			$result = true;
		}
		if ($result) {
			return new $this->_classes['recordSet'](array(
				'items' => array(new $this->_classes['recordObject']($full))
			));
		}
		return null;
	}

	/**
	 * Source name
	 *
	 * @param string $table
	 * @return string
	 */
	public function name($table) {
		return preg_replace('/\W-/', '', $table);
	}

	/**
	 * Create method for data source, saves uploaded file to resource path
	 *
	 * @param string $query
	 * @param string $options
	 * @return void
	 */
	public function create($query, $options = array()) {
		$params = compact('query', 'options');
		$path = $this->_path;

		return $this->_filter(__METHOD__, $params, function($self, $params) use ($path) {
			extract($params);
			extract($query->export($self), EXTR_OVERWRITE);
			$data = $query->data();
			$filename = preg_replace('/\W-/', '', $data['name']);
			$contents = file_get_contents($data['tmp_name']);
			$file = "{$path}/{$table}/{$filename}";
			if (file_put_contents($file, $contents)) {
				$query->conditions(array('name' => $filename));
				$record = $self->read($query, $options);
				return $query->record()->data = $record;
			}
			return false;
		});
	}

	/**
	 * Reads files from resource path
	 *
	 * @param string $query
	 * @param string $options
	 * @return mixed
	 */
	public function read($query, $options = array()) {
		$params = compact('query', 'options');
		$path = $this->_path;
		$config = $this->_config;

		return $this->_filter(__METHOD__, $params, function($self, $params) use ($path, $config) {
			extract($params);
			extract($query->export($self), EXTR_OVERWRITE);

			if (!is_callable($conditions['format'])) {
				$conditions['format'] = function ($file, $config) use ($options){
					return new $options['classes']['recordObject']($file);
				};
			}
			if (!empty($conditions['name'])) {
				$file = "{$path}/{$table}/{$conditions['name']}";
				if (!file_exists($file)) {
					return false;
				}
				return $conditions['format']($file, $config);
			}
			$conditions['path'] = "{$config['path']}/{$table}";
			$files = Libraries::find($config['library'], $conditions);
			return $files;
		});
	}

	public function update($query, $options) {
		return $this->create($query, $options);
	}

	public function delete($query, $options) {
		return compact('query', 'options');
	}

	public function conditions($conditions, $context) {
		$defaults = array(
			'namespaces' => true, 'recursive' => false,
			'filter' => '', 'exclude' => '',
			'format' => ''
		);
		$conditions = (array)$conditions + $defaults;
		return $conditions;
	}

	public function result($type, $resource, $context) {
		$result = null;
		switch ($type) {
			case 'next':
				if (isset($resource[$this->_iterator])) {
					return $resource[$this->_iterator++];
				}
			break;
			case 'close':
				unset($resource);
			break;
		}
		if (!is_object($result)) {
			$this->_iterator = 0;
		}
		return $result;
	}
}

?>