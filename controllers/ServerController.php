<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \Phar;

/**
 * Server Controller
 *
 */
class ServerController extends \lithium\action\Controller {

	/**
	 * Receive the phar archive from `lab push`, save the archive, extract, and insert formula
	 *
	 * @return void
	 */
	public function receive() {
		if (!empty($this->request->data['phar'])) {
			$file = $this->request->data['phar'];
			$plugins = LITHIUM_APP_PATH . "/resources/plugins";
			if (!is_dir($plugins)) {
				mkdir($plugins);
			}
			$local = "{$plugins}/{$file['name']}";
			$contents = file_get_contents($file['tmp_name']);
			file_put_contents($local, base64_decode($contents));
			$archive = new Phar($local);
			$name = basename($local, '.phar');
			$saved = dirname($local) . '/' . $name;
			if ($archive->extractTo($saved)) {
				return Formula::save(file_get_contents("{$saved}/config/{$name}.json"));
			}
		}
		return false;
	}
}