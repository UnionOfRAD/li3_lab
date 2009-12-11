<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\mocks\extensions\command;

class MockService extends \lithium\http\Service {

	public function send($method, $path = null, $data = array(), $options = array()) {
		if ($path == 'lab') {
			return json_encode($this->__data());
		}

		if (preg_match("/lab\/(.*?).json/", $path)) {
			return json_encode($this->__data(1));
		}
	}
	
	private function __data($key = null) {
		$data = array(
			array(
				'name' => 'li3_lab', 'version' => '1.0',
				'summary' => 'the li3 plugin client/server',
				'maintainers' => array(
					'name' => 'gwoo',
					'email' => 'gwoo@nowhere.com',
					'website' => 'li3.rad-dev.org'
				),
				'created' => '2009-11-30', 'updated' => '2009-11-30',
				'rating' => '9.9', 'downloads' => '1000',
				'sources' => array(
					'git' => 'git://rad-dev.org/li3_lab.git',
					'gz' => 'http://downloads.rad-dev.org/li3_lab.tar.gz'
				),
				'requires' => array()
			),
			array(
				'name' => 'li3_example', 'version' => '1.0',
				'summary' => 'and li3 plugin example',
				'maintainers' => array(
					'name' => 'gwoo',
					'email' => 'gwoo@nowhere.com',
					'website' => 'li3.rad-dev.org'
				),
				'created' => '2009-11-30', 'updated' => '2009-11-30',
				'rating' => '9.9', 'downloads' => '1000',
				'sources' => array(
					'phar' =>  dirname(dirname(dirname(__DIR__))) . '/fixtures/plugins/li3_example.phar'
				),
				'requires' => array(
					'li3_lab' => array('version' => '<=1.0')
				)
			),
		);
		if (isset($data[$key])) {
			return $data[$key];
		}
		if ($key !== null) {
			return null;
		}
		return $data;
	}
}

?>