<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\models;

use \li3_lab\models\Repo;
use \lithium\data\Connections;

class RepoTest extends \lithium\test\Unit {

	public function setUp() {
		Connections::add('test_resources', 'Media', array('path' => '/resources/tmp/tests'));
		$this->_fixturesPath = dirname(dirname(__DIR__));
	}

	public function testSaveAndFind() {
		Repo::meta('connection', 'test_resources');
		$repo = Repo::create(array(
			'name' => 'li3_example.phar.gz', 'type' => 'application/phar',
			'tmp_name' => $this->_fixturesPath . '/fixtures/plugins/li3_example.phar.gz',
		));
		$result = $repo->save();
		$this->assertTrue($result);

		$file = LITHIUM_APP_PATH . '/resources/tmp/tests/repos/li3_example.phar.gz';
		$result = file_exists($file);
		$this->assertTrue($result);

		$repo = Repo::find('all');

		$expected = 'li3_example.phar.gz';
		$result = $repo->current()->getFilename();
		$this->assertEqual($expected, $result);
	}

	public function testSaveAndFindFileObject() {
		Repo::meta('connection', 'test_resources');
		$repo = Repo::create(array(
			'name' => 'li3_example.json', 'type' => 'text/json',
			'tmp_name' => $this->_fixturesPath . '/fixtures/plugins/li3_example/config/li3_example.json',
		));
		$result = $repo->save();
		$this->assertTrue($result);

		$file = LITHIUM_APP_PATH . '/resources/tmp/tests/repos/li3_example.json';
		$result = file_exists($file);
		$this->assertTrue($result);

		$repo = Repo::find('all', array('conditions' => array('format' => function ($file) {
			return new \SplFileObject($file);
		})));

		$expected = 'li3_example.json';
		$result = $repo->current()->getFilename();
		$this->assertEqual($expected, $result);

		$expected = 'li3_example';
		$result = json_decode($repo->current()->contents());
		$this->assertEqual($expected, $result->name);

		$this->_cleanUp();
	}
}

?>