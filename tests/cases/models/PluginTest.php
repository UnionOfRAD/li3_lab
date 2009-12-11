<?php

namespace li3_lab\tests\cases\models;

use \li3_lab\tests\mocks\models\MockPlugin;

class PluginTest extends \lithium\test\Unit {

	public function testValidation() {
		$plugin = MockPlugin::create(array('maintainer' => 'new plugin'));

		$result = $plugin->validates();
		$this->assertTrue($result === false);
		$result = $plugin->errors();
		$this->assertTrue(!empty($result));

		$expected = array(
			'maintainer_email' => array('You must specify a valid maintainer email address.'),
			'version' => array('You must specify a version number for this plugin.'),
			'name' => array('You must specify a name for this plugin.'),
			'summary' => array('You must specify a short summary for this plugin'),
			'source' => array('You must specify a source for this plugin.'),
		);
		$result = $plugin->errors();
		$this->assertEqual($expected, $result);

	}
}