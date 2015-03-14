<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\extensions\data\source;

use \lithium\core\Libraries;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

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
		'entity' => 'li3_lab\extensions\data\model\File',
		'set' => 'li3_lab\extensions\data\model\Directory',
		'object' => 'SplFileInfo',
	);

	/**
	 * Error messages for possible upload errors.
	 *
	 * @var array
	 */
	protected $_errors = array(
		null,
		"The uploaded file exceeds the upload_max_filesize directive in php.ini",
		"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
		"The uploaded file was only partially uploaded",
		"No file was uploaded",
		"Missing a temporary folder"
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
	public function sources($class = null) {
		return array_map('basename', glob($this->_path . '/*', GLOB_ONLYDIR));
	}

	public function describe($entity, array $meta = array()) {
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
			return new $this->_classes['set'](array(
				'items' => array(new $this->_classes['object']($full))
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
	public function create($query, array $options = array()) {
		$params = compact('query', 'options');
		$path = $this->_path;
		$errors = $this->_errors;

		return $this->_filter(__METHOD__, $params, function($self, $params) use ($path, $errors) {
			extract($params);
			extract($query->export($self), EXTR_OVERWRITE);
			$data = $query->data();

			if(!empty($data['error']) && isset($errors[$data['error']])) {
				$query->entity()->errors('file', $errors[$data['error']]);
				return false;
			}
			$filename = preg_replace('/\W-/', '', $data['name']);

			if (!empty($data['tmp_name'])) {
				if (!file_exists($data['tmp_name'])) {
					$query->entity()->errors('file', $data['tmp_name'] . 'does not exist');
					return false;
				}
				$data['contents'] = file_get_contents($data['tmp_name']);
			}

			if (empty($data['contents'])) {
				return false;
			}
			if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data['contents'])) {
				$data['contents'] = base64_decode($data['contents']);
			}
			$file = "{$path}/{$table}/{$filename}";

			if (file_put_contents($file, $data['contents'])) {
				$query->conditions(array('name' => $filename));
				$entity = $self->read($query, $options);
				return $query->entity()->data = $entity;
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
	public function read($query, array $options = array()) {
		$params = compact('query', 'options');
		$path = $this->_path;
		$config = $this->_config;

		return $this->_filter(__METHOD__, $params, function($self, $params) use ($path, $config) {
			extract($params);
			extract($query->export($self), EXTR_OVERWRITE);

			if (!is_callable($conditions['format'])) {
				$conditions['format'] = function ($file, $config) use ($options){
					return $this->_instance('object', $file);
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

	public function update($query, array $options = array()) {
		return $this->create($query, $options);
	}

	public function delete($query, array $options = array()) {
		$params = compact('query', 'options');
		$path = $this->_path;
		$config = $this->_config;

		return $this->_filter(__METHOD__, $params, function($self, $params) use ($path, $config) {
			extract($params);
			extract($query->export($self), EXTR_OVERWRITE);
			$data = $query->data();
			$conditions += $options;
			if (empty($conditions['name']) && is_object($data[0])) {
				$conditions['name'] = $data[0]->getFilename();
			}
			if (!empty($conditions['name'])) {
				$file = "{$path}/{$table}/{$conditions['name']}";

				if (!file_exists($file)) {
					return true;
				}
				if (is_file($file)) {
					return (boolean) unlink($file);
				}
				$iterator = new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator($file), RecursiveIteratorIterator::CHILD_FIRST
				);
				foreach ($iterator as $item) {
					($item->isDir()) ? rmdir($item->getPathname()) : unlink($item->getPathname());
				}
				return (boolean) rmdir($file);
			}
			return false;
		});
	}

	public function conditions($conditions, $context) {
		$defaults = array(
			'namespaces' => false, 'recursive' => false,
			'filter' => '', 'exclude' => '', 'suffix' => false,
			'format' => ''
		);
		$conditions = (array) $conditions + $defaults;
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

	public function relationship($class, $type, $name, array $options = array()) {
		
	}
}

?>