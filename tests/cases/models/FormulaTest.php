<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\models;

use \li3_lab\models\Formula;

class FormulaTest extends \lithium\test\Unit {

	public function testSave() {
		$path = dirname(dirname(__DIR__));
		$formula = Formula::create(array(
			'name' => 'li3_example.json', 'type' => 'text/json',
			'tmp_name' => $path . '/fixtures/plugins/li3_example/config/li3_example.json',
		));
		$result = $formula->save();

		$file = LITHIUM_APP_PATH . '/resources/formulas/li3_example.json';
		$result = file_exists($file);
		$this->assertTrue($result);

		$data = json_decode(str_replace(array("\r\n", "\n", "\t"), '', file_get_contents($file)));
		$expected = 'li3_example';
		$result = $data->name;
		$this->assertEqual($expected, $result);

		$data = json_decode($formula->contents());
		$expected = 'li3_example';
		$result = $data->name;
		$this->assertEqual($expected, $result);


		$this->_cleanUp();
	}
}
?>
