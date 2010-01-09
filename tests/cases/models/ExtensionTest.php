<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\models;

use \li3_lab\tests\mocks\models\MockExtension;

class ExtensionTest extends \lithium\test\Unit {

	public function testValidationEmpty() {
		$extension = MockExtension::create();

		$this->assertFalse($extension->validates());
		$errors = $extension->errors();
		$this->assertTrue(!empty($errors));

		$expected = array(
			'name' => array('You must specify a name.'),
			'summary' => array('You must specify a short summary.'),
			'description' => array('You must specify a longer description.'),
			'maintainers' => array('Must specify at least one with at least an email.'),
			'code' => array('Must be a class with a namespace.')
		);
		$this->assertEqual($expected, $errors);
	}

	public function testValidationCode() {
		$extension = MockExtension::create(array('code' => 'function($da) { run(); }'));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('code');
		$this->assertTrue(!empty($result));

		$extension = MockExtension::create(array('code' => 'class John extends JohnSenior {}'));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('code');
		$this->assertTrue(!empty($result));

		$extension = MockExtension::create(array('code' =>
			'<?php namespace names\male; class John extends JohnSenior {}'));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('code');
		$this->assertTrue(empty($result));
	}

	public function testValidationMaintainers() {
		$extension = MockExtension::create(array('maintainers' => array()));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('maintainers');
		$this->assertTrue(!empty($result));

		$extension = MockExtension::create(array('maintainers' => array(
			array('name' => 'john', 'email' => null, 'website' => null)
		)));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('maintainers');
		$this->assertTrue(!empty($result));

		$extension = MockExtension::create(array('maintainers' => array(
			array('name' => 'john', 'email' => 'john@example.org', 'website' => null)
		)));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('maintainers');
		$this->assertTrue(empty($result));

		$extension = MockExtension::create(array('maintainers' => array(
			array('name' => null, 'email' => 'john@example.org', 'website' => 'example.org'),
			array('name' => 'Ralph', 'email' => 'ralph@example.org', 'website' => null)
		)));
		$this->assertFalse($extension->validates());
		$result = $extension->errors('maintainers');
		$this->assertTrue(empty($result));
	}

	public function testSaveFilterCreated() {
		$extension = MockExtension::create(MockExtension::$mockData);
		$default = $extension->created;
		$result = $extension->save();
		$current = $extension->created;
		$this->assertTrue($default != $current);
	}

	public function testSaveFilterNamespace() {
		$extension = MockExtension::create(MockExtension::$mockData);
		$result = $extension->save();
		$this->assertFalse($result);

		$expected = 'li3_lab\tests\mocks\models';
		$result = $extension->namespace;
		$this->assertEqual($expected, $result);
	}

	public function testSaveFilterClass() {
		$extension = MockExtension::create(MockExtension::$mockData);
		$result = $extension->save();
		$this->assertFalse($result);

		$expected = 'MockExtension';
		$result = $extension->class;
		$this->assertEqual($expected, $result);
	}

	public function testSaveFilterFile() {
		$extension = MockExtension::create(MockExtension::$mockData);
		$result = $extension->save();
		$this->assertFalse($result);

		$expected = 'li3_lab\tests\mocks\models\mock_extension.php';
		$result = $extension->file;
		$this->assertEqual($expected, $result);
	}
}

?>