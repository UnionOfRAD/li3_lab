<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\extensions\command;

use \Phar;
use \lithium\console\Dispatcher;
use \lithium\console\Request;
use \lithium\action\Request as ActionRequest;
use \li3_lab\extensions\command\Lab;

class LabTest extends \lithium\test\Unit {

	public $lab = null;

	protected $_conf = null;

	protected $_installPath = null;

	protected $_fixturesPath = null;

	public function setUp() {
		$this->_fixturesPath = dirname(dirname(dirname(__DIR__))) . '/fixtures/plugins';
		$this->_installPath = LITHIUM_APP_PATH . '/resources/tmp/tests';
		$this->_conf = LITHIUM_APP_PATH . '/resources/tmp/tests/li3_lab.ini';
		Dispatcher::applyFilter('_call', function($self, $params, $chain) {
			$result = $chain->next($self, $params, $chain);
			if (!$result) {
				return false;
			}
			return $params['callable'];
		});

		$classes = array(
			'service' => '\li3_lab\tests\mocks\extensions\command\MockService',
			'response' => '\lithium\tests\mocks\console\MockResponse'
		);
		$request = new Request();
		$this->lab = new Lab(compact('request', 'classes'));
	}

	public function tearDown() {
		if (file_exists($this->_conf)) {
			// /unlink($this->_conf);
		}
	}

	public function testBasicInit() {
		$lab = Dispatcher::run(new Request(array(
			'args' => array(
				'\li3_lab\extensions\command\Lab',
				'init', "--conf={$this->_conf}",
			)
		)));
		$result = file_exists($this->_conf);
		$this->assertTrue($result);

		$expected = array('servers' => array('lab.lithify.me' => true));
		$result = parse_ini_file($this->_conf, true);
		$this->assertEqual($expected, $result);
	}

	public function testServerConfig() {
		$lab = Dispatcher::run(new Request(array(
			'args' => array(
				'\li3_lab\extensions\command\Lab',
				'config', "--conf={$this->_conf}", 'server', 'incubator.lithify.me'
			)
		)));

		$expected = array('servers' => array(
			'lab.lithify.me' => true,
			'incubator.lithify.me' => true
		));
		$result = parse_ini_file($this->_conf, true);
		$this->assertEqual($expected, $result);
	}

	public function testCreate() {
		$this->lab->path = $this->_installPath;
		$this->lab->original = $this->_fixturesPath;
		$result = $this->lab->create('li3_example');
		$this->assertTrue($result);

		$result = file_exists($this->_installPath . '/li3_example.phar.gz');
		$this->assertTrue($result);

		$expected = 2000;
		$result = filesize($this->_installPath . '/li3_example.phar.gz');
		$this->assertTrue($expected < $result);

		Phar::unlinkArchive($this->_installPath . '/li3_example.phar');
		Phar::unlinkArchive($this->_installPath . '/li3_example.phar.gz');
		$this->_cleanUp();
	}

	public function testPush() {
		$this->lab->path = $this->_installPath;
		$this->lab->original = $this->_fixturesPath;
		$result = $this->lab->create('li3_example');
		$this->assertTrue($result);

		$result = file_exists($this->_installPath . '/li3_example.phar.gz');
		$this->assertTrue($result);

		$request = new ActionRequest();
		$this->lab->server = $request->env('HTTP_HOST') . $request->env('base');
		$result = $this->lab->push('li3_example');

		$result = is_dir($this->_installPath . '/li3_example');
		$this->assertTrue($result);
	}

	public function testAdd() {
		$this->lab->path = $this->_installPath;
		$result = $this->lab->add('li3_example');
		$this->assertTrue($result);

		$result = file_exists($this->_installPath . '/li3_example.phar');
		$this->assertTrue($result);

		$result = is_dir($this->_installPath . '/li3_example');
		$this->assertTrue($result);
		$this->_cleanUp();
	}

	public function testFind() {
		$this->lab->run();

$expected = <<<EOD
--------------------------------------------------------------------------------
lab.lithify.me > li3_lab
--------------------------------------------------------------------------------
the li3 plugin client/server
Version: 1.0
Created: 2009-11-30
--------------------------------------------------------------------------------
lab.lithify.me > li3_example
--------------------------------------------------------------------------------
an li3 plugin example
Version: 1.0
Created: 2009-11-30

EOD;
		$result = $this->lab->response->output;
		$this->assertEqual($expected, $result);
	}
}

?>