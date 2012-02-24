<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

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
				$name = $file->getBasename('.phar.gz');
				$formula = Formula::create(array(
					'name' => "{$name}.json", 'type' => 'application/json',
					'tmp_name' => "phar://" . $file->getPathname() . "/config/{$name}.json"
				));
 				if ($formula->save()) {
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