<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\cases\extensions\data\source;

use \li3_lab\extensions\data\source\Media;
use \lithium\data\Connections;
use \lithium\data\Model;
use \lithium\data\model\Query;
use \lithium\data\model\Record;

class MediaTest extends \lithium\test\Unit {
	
	protected $_testPath;
	
	public function setUp() {
		$this->_testPath = LITHIUM_APP_PATH . '/resources/tmp/tests';
		Connections::add('media_test', 'Media', array(
			'path' => '/resources/tmp/tests', 'mode' => 0777
		));
		$this->classes = array(
			'record' => '\li3_lab\extensions\data\model\File',
			'recordSet' => '\li3_lab\extensions\data\model\Directory',
			'recordObject' => '\SplFileInfo',
		);
		MockUpload::__init();
		$this->query = new Query(array(
			'model' => '\li3_lab\tests\cases\extensions\data\source\MockUpload',
			'record' => new Record(),
		));
	}

	public function tearDown() {
		unset($this->query);
	}
	
	public function testAllMethodsNoConnection() {
		$media = new Media(array('path' => '/something/that/does/not/exist'));
		$this->assertFalse($media->connect());
		$this->assertTrue($media->disconnect());
	}
	
	public function testConnection() {
		$media = new Media(array('path' => '/resources/tmp/tests'));
		$this->assertTrue($media->connect());
		$this->assertTrue($media->disconnect());
	}
	
	public function testDescribe() {
		$media = new Media(array('path' => '/resources/tmp/tests'));
		
		$expected = array(
			'path' => $this->_testPath,
			'entity' => "mock_uploads"
		);
		$result = $media->describe('mock_uploads');
		$this->assertTrue(is_object($result));

		$expected = 'mock_uploads';
		$this->assertEqual($expected, $result->getFilename());
	}
	
	public function testEntities() {
		$media = new Media(array('path' => '/resources/tmp/tests'));
		
		$expected = array("mock_uploads");
		$result = $media->entities();
		$this->assertEqual($expected, $result);
	}
	
	public function testCreate() {
		$media = new Media(array('path' => '/resources/tmp/tests'));
		$this->query->data(array(
			'name' => 'some_file.phar.gz', 'type' => 'application/tar',
			'tmp_name' => LITHIUM_LIBRARY_PATH . '/lithium/console/command/build/template/app.phar.gz'
		));
		$result = $media->create($this->query, array('classes' => $this->classes));
		$this->assertTrue(is_object($result));
		
		$expected = 'some_file.phar.gz';
		$this->assertEqual($expected, $result->getFilename());
		
		$result = file_exists("{$this->_testPath}/mock_uploads/some_file.phar.gz");
		$this->assertTrue($result);		
	}
	
	public function testRead() {
		$media = new Media(array('path' => '/resources/tmp/tests'));
		$expected = 1;
		$result = $media->read($this->query, array('classes' => $this->classes));
		$this->assertEqual($expected, count($result));
		
		$expected = 'some_file.phar.gz';
		$result = basename($result[0]);
		$this->assertEqual($expected, $result);

		$this->_cleanUp();
	}
}

class MockUpload extends \lithium\data\Model {
	
	protected $_meta = array('connection' => 'media_test');
}