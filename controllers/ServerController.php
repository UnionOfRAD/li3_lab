<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \Phar;
use li3_lab\models\Repo;
use li3_lab\models\Formula;

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
			$file = Repo::create($this->request->data['phar']);
			if ($file->save()) {
				$archive = new Phar($file->getPathname());
				$name = basename($file->getFilename(), '.phar');
				$saved = $file->getPath() . '/' . $name;
				if ($archive->extractTo($saved)) {
					return Formula::save(array(
						'name' => "{$name}.json", 'type' => 'application/json',
						'tmp_name' => "{$saved}/config/{$name}.json"
					));
				}
			}
		}
		return false;
	}
}