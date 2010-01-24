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
use li3_lab\models\Plugin;

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
		$errors = false;
		if (!empty($this->request->data['phar'])) {
			$file = Repo::create($this->request->data['phar']);

			if ($file->save()) {
				$archive = new Phar($file->getPathname());
				$name = $file->getBasename('.gz');
				$name = basename($name, '.phar');
				$saved = $file->getPath() . '/' . $name;

				if ($archive->extractTo($saved)) {
					$formula = Formula::create(array(
						'name' => "{$name}.json", 'type' => 'application/json',
						'tmp_name' => "{$saved}/config/{$name}.json"
					));
					if ($formula->save()) {
						$folder = Repo::create(array('name' => $name));
						$folder->delete();
						$plugin = Plugin::create(json_decode($formula->contents(), true));
						if ($plugin->save()) {
							return $this->render(
								array('json' => $plugin->data(), 'status' => 201)
							);
						}
						$errors = $plugin->errors();
					}
					if (!$errors) {
						$errors = $formula->errors();
					}
				}
			}
			if (!$errors) {
				$errors = $file->errors();
			}
			$file->delete();
			return $this->render(array('json' => $errors, 'status' => 406));
		}
		return 'missing phar.gz';
	}
}

?>