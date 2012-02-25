<?php

namespace li3_lab\tests\cases\controllers;

use lithium\data\Connections;
use li3_lab\controllers\ServerController;
use lithium\action\Request;
use lithium\action\Response;
use li3_lab\models\Repo;
use li3_lab\models\Formula;
use li3_lab\models\Plugin;

class ServerControllerTest extends \lithium\test\Unit {

	public $request;

	public function setUp() {
		Connections::add('test_resources', array(
			'type' => 'Media',
			'path' => '/resources/tmp/tests'
		));

		$this->_fixturesPath = dirname(dirname(__DIR__));
		$this->_cleanUp();

		$this->request = new Request();
		$this->server = new ServerController(array('request' => $this->request));
		$this->server->response = new Response();

		Repo::meta('connection', 'test_resources');
		Repo::connection()->describe(Repo::meta('source'));

		Formula::meta('connection', 'test_resources');
		Formula::connection()->describe(Formula::meta('source'));

		Plugin::meta('source', 'test_li3_lab');
		Plugin::connection()->describe(Plugin::meta('source'));
	}

	public function tearDown() {
		Repo::meta('connection', 'resources');
		Repo::connection()->describe(Repo::meta('source'));

		Formula::meta('connection', 'resources');
		Formula::connection()->describe(Formula::meta('source'));

		Plugin::meta('source', 'li3_lab');
		Plugin::connection()->describe(Plugin::meta('source'));
	}

	public function testReceive() {
		$this->request->data['phar'] = array(
			'name' => 'li3_example.phar.gz',
			'type' => 'application/phar',
			'tmp_name' => "{$this->_fixturesPath}/fixtures/plugins/li3_example.phar.gz"
		);

		$this->server->receive();
		$result = json_decode($this->server->response->body());

		$expected = 'li3_example';
		$this->assertEqual($expected, $result->name);

		$file = LITHIUM_APP_PATH . '/resources/tmp/tests/repos/li3_example.phar.gz';
		$result = file_exists($file);
		$this->assertTrue($result);

		$this->_cleanUp();
		Plugin::create()->delete();
	}
}

?>