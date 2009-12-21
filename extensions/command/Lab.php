<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\extensions\command;

use \lithium\http\Service;
use \Phar;
/**
 * Client for adding, creating, updating li3 plugins
 *
 */
class Lab extends \lithium\console\Command {

	/**
	 * path to save and add plugins
	 *
	 * @var string
	 */
	public $path = null;

	/**
	 * path of original plugins used when creating archives
	 *
	 * @var string
	 */
	public $original = null;

	/**
	 * Absolute path to config file
	 *
	 * @var string
	 */
	public $conf = null;

	/**
	 * server hosts to query for plugins
	 *
	 * @var array
	 */
	public $server = 'plugins.rad-dev.org';

	/**
	 * Holds settings from conf file
	 *
	 * @var array
	 */
	protected $_settings = array();

	/**
	 * some classes
	 *
	 * @package default
	 */
	protected $_classes = array(
		'service' => '\lithium\http\Service',
		'response' => '\lithium\console\Response'
	);

	/**
	 * Constuctor
	 *
	 * @param string $config
	 */
	public function __construct($config = array()) {
		$this->conf = LITHIUM_APP_PATH . '/config/li3_lab.ini';
		$this->path = LITHIUM_APP_PATH . '/libraries/plugins';
		$this->original = $this->path;
		parent::__construct($config);
	}

	/**
	 * Initializer sets _config from conf
	 *
	 * @return void
	 */
	protected function _init() {
		parent::_init();
		if (file_exists($this->conf)) {
			$this->_settings += parse_ini_file($this->conf, true);
		}
		$this->_settings['servers'][$this->server] = true;
	}

	/**
	 * List all the plugins
	 *
	 * @return void
	 */
	public function find() {
		$results = array();
		foreach ($this->_settings['servers'] as $server) {
			$service = new $this->_classes['service'](array('host' => $server));
			$results[$server] = json_decode($service->get('lab'));
			foreach ($results[$server] as $plugin) {
				$this->header($plugin->name);
			}
		}
	}

	/**
	 * Add plugins to current application
	 *
	 * @return boolean
	 */
	public function add($plugin = null) {
		$results = array();
		foreach ($this->_settings['servers'] as $server) {
			$service = new $this->_classes['service'](array('host' => $server));
			$results[$server] = json_decode($service->get("lab/{$plugin}.json"));
		}
		if (count($results) == 1) {
			$plugin = current($results);
		}

		$this->header($plugin->name);

		if (isset($plugin->sources->git) && strpos(shell_exec('git --version'), 'git version 1.6') !== false) {
			$result = shell_exec("cd {$this->path} && git clone {$plugin->sources->git}");
		} elseif (isset($plugin->sources->phar)) {
			$remote = $plugin->sources->phar;
			$local = $this->path . '/' . basename($plugin->sources->phar);
			$write = file_put_contents($local, file_get_contents($remote));
			$archive = new Phar($local);
			return $archive->extractTo($this->path . '/' . basename($plugin->sources->phar, '.phar'));
		}
		return false;
	}
	
	/**
	 * Send a plugin to the server
	 *
	 * @param string $name 
	 * @return void
	 */
	public function push($name = null) {
		$file = "{$this->path}/{$name}.phar";
		if (file_exists($file)) {
			$boundary = md5(date('r', time()));
			$service = new Service(array('host' => $this->server, 'port' => '30501'));
			$headers = array(
				"Content-Type: multipart/form-data; boundary={$boundary}"
			);
			$data = join("\r\n", array(
				"--{$boundary}",
				"Content-Disposition: form-data; name=\"phar\"; filename=\"{$file}\"",
				"Content-Type: application/phar", "",
				base64_encode(file_get_contents($file)),
				"--{$boundary}--"
			));
			$result = $service->post('/lab/server/receive', $data, compact('headers'));
			return $result;
		}
	}

	/**
	 * Update installed plugins
	 *
	 * @return boolean
	 */
	public function update() {

	}

	/**
	 * Create a new archive and formula
	 *
	 * @return boolean
	 */
	public function create($name = null) {
		if (!$name) {
			$this->out("please supply a name");
			return false;
		}
		$result = false;
		$path = "{$this->original}/{$name}";

		if (file_exists($path)) {
			if (!file_exists("{$path}/config/{$name}.json")) {
				$formula = json_encode(array('name' => $name));
				file_put_contents("{$path}/config/{$name}.json", $formula);
			}
			$archive = new Phar("{$this->path}/{$name}.phar");
			$result = (bool) $archive->buildFromDirectory($path);
		}
		if ($result) {
			$this->out("{$name} created in {$this->path}");
			return true;
		}
		$this->error("{$name} not created in {$this->path}");
		return true;
	}

	/**
	 * Add some configuration
	 *
	 * @return void
	 */
	public function config($key = null, $value = null, $options = true) {
		if (empty($key) || empty($value)) {
			return false;
		}
		switch($key) {
			case 'server':
				$this->_settings['servers'][$value] = $options;
			break;
		}
		return $this->_writeConf();
	}

	/**
	 * Creates the conf file
	 *
	 * @return void
	 */
	public function init() {
		if (!file_exists($this->conf)) {
			return $this->_writeConf(array('servers' => (array) $this->server));
		}
		return false;
	}

	/**
	 * Helper method for writing conf file
	 *
	 * @param array $settings
	 * @return boolean
	 */
	protected function _writeConf($settings = null) {
		if ($settings === null) {
			$settings = $this->_settings;
		}
		$data = array();
		$writer = function($conf) use (&$writer, &$data) {
			foreach((array)$conf as $key => $value) {
				if (is_array($value)) {
					$data[] = "[{$key}]";
					$data[] = $writer($value);
				} else {
					if (is_numeric($key)) {
						$key = $value;
						$value = true;
					}
					$value = var_export($value, true);
					$data[] = "{$key} = \"{$value}\"";
				}
			}
		};
		$writer($settings);
		return (bool) file_put_contents($this->conf, join("\n", $data));
	}
}

?>