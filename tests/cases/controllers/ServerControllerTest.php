<?php

namespace li3_lab\tests\cases\controllers;

use \li3_lab\models\Repo;
use \lithium\data\Connections;
use \li3_lab\controllers\ServerController;
use \lithium\action\Request;

class ServerControllerTest extends \lithium\test\Unit {

	public $request;

	public function setUp() {
		Connections::add('test_resources', 'Media', array('path' => '/resources/tmp/tests'));
		$this->request = new Request();
		$this->_fixturesPath = dirname(dirname(__DIR__));
		$this->_cleanUp();
		Repo::invokeMethod('_connection')->describe(Repo::meta('source'));
	}

	public function tearDown() {}

	public function testReceive() {
		$this->request->data['phar'] = array(
			'name' => 'li3_example.phar', 'type' => 'application/phar',
			'tmp_name' => $this->_fixturesPath  . '/fixtures/plugins/li3_example.phar',
		);
		$server = new ServerController(array('request' => $this->request));
		Repo::meta('connection', 'test_resources');
		$result = $server->receive();

		$expected = 'li3_example';
		$this->assertEqual($expected, $result['name']);


		$file = LITHIUM_APP_PATH . '/resources/tmp/tests/repos/li3_example.phar';
		$result = file_exists($file);
		$this->assertTrue($result);

		$this->_cleanUp();
	}
}

?>