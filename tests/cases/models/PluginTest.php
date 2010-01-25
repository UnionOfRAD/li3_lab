<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\models;

use \li3_lab\tests\mocks\models\MockPlugin;
use \lithium\data\Connections;
use \lithium\data\model\Query;

class PluginTest extends \lithium\test\Unit {

	public function setUp() {
		Connections::add('test_li3_lab', 'http', array('adapter' => 'CouchDb'));
	}

	protected $_data = array(
		'name' => 'li3_bot',
		'version' => '0.3',
		'summary' => 'a bot with connection to irc',
		'maintainers' => array(
			0 => 	array(
				'name' => 'gwoo',
				'email' => 'gwoo@rad-dev.org',
				'website' => 'li3.rad-dev.org',
			),
		),
		'sources' => array(
			'git' => 'git://rad-dev.org/li3_bot.git',
		),
		'commands' => array(
			'add' => 	array(
				0 => 'install',
			),
		),
	);

	public function testValidation() {
		$plugin = MockPlugin::create();

		$result = $plugin->validates();
		$this->assertTrue($result === false);
		$result = $plugin->errors();
		$this->assertTrue(!empty($result));

		$expected = array(
			'name' => array(
				'You must specify a name for this plugin.',
				'Name must be unique.'
			),
			'version' => array('You must specify a version for this plugin.'),
			'summary' => array('You must specify a short summary for this plugin'),
			'sources' => array('You must specify a source for this plugin.'),
		);
		$result = $plugin->errors();
		$this->assertEqual($expected, $result);
	}

	public function testSave() {
		$plugin = MockPlugin::create($this->_data);
		$result = $plugin->save();
		$this->assertTrue($result);
	}

	public function testSaveAndFind() {
		$plugin = MockPlugin::create($this->_data);
		$result = $plugin->save();
		$this->assertTrue($result);

		$plugin = MockPlugin::find(MockPlugin::find('first')->id);

		$expected = 'li3_bot';
		$result = $plugin->name;
		$this->assertEqual($expected, $result);

		MockPlugin::create()->delete();
	}
}

?>