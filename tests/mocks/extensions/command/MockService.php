<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\mocks\extensions\command;

class MockService extends \lithium\net\http\Service {

	public function send($method, $path = null, $data = array(), $options = array()) {
		if ($path == 'lab/plugins') {
			return json_encode($this->__data('plugins'));
		}
		if ($path == 'lab/extensions') {
			return json_encode($this->__data('extensions'));
		}
		if (preg_match("/lab\/(.*?).json/", $path, $match)) {
			return json_encode($this->__data('plugins', 1));
		}
	}

	private function __data($type, $key = null) {
		$plugins = array(
			array(
				'name' => 'li3_lab', 'version' => '1.0',
				'summary' => 'the li3 plugin client/server',
				'maintainers' => array(
					array(
						'name' => 'gwoo', 'email' => 'gwoo@nowhere.com',
						'website' => 'li3.rad-dev.org'
					)
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
				'summary' => 'an li3 plugin example',
				'maintainers' => array(
					array(
						'name' => 'gwoo', 'email' => 'gwoo@nowhere.com',
						'website' => 'li3.rad-dev.org'
					)
				),
				'created' => '2009-11-30', 'updated' => '2009-11-30',
				'rating' => '9.9', 'downloads' => '1000',
				'sources' => array(
					'phar' =>
						dirname(dirname(dirname(__DIR__))) . '/fixtures/plugins/li3_example.phar.gz'
				),
				'requires' => array(
					'li3_lab' => array('version' => '<=1.0')
				)
			)
		);

		$extensions = array(
			array(
				'class' => 'Example', 'namespace' => 'app\extensions\adapter\cache',
				'summary' => 'the example adapter',
				'maintainers' => array(
					array(
						'name' => 'gwoo', 'email' => 'gwoo@nowhere.com',
						'website' => 'li3.rad-dev.org'
					)
				),
				'created' => '2009-11-30', 'updated' => '2009-11-30',
				'rating' => '9.9', 'downloads' => '1000'
			),
			array(
				'class' => 'Paginator', 'namespace' => 'app\extensions\helpes',
				'summary' => 'a paginator helper',
				'maintainers' => array(
					array(
						'name' => 'gwoo', 'email' => 'gwoo@nowhere.com',
						'website' => 'li3.rad-dev.org'
					)
				),
				'created' => '2009-11-30', 'updated' => '2009-11-30',
				'rating' => '9.9', 'downloads' => '1000'
			)
		);
		$data = compact('plugins', 'extensions');

		if (isset($data[$type][$key])) {
			return $data[$type][$key];
		}
		if (isset($data[$type])) {
			return $data[$type];
		}
		if ($key !== null) {
			return null;
		}
		return $data;
	}
}

?>