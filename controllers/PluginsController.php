<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \li3_lab\models\Plugin;
use \li3_lab\models\Formula;

/**
 * Plugins Controller
 *
 */
class PluginsController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$params = array(
			'conditions'=> array('design' => 'latest', 'view' => 'plugins'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latest = Plugin::all($params);
		if ($this->request->type == 'json') {
			$this->render(array('json' => $latest->to('array')));
		}
		return compact('latest');
	}

	/**
	 * View
	 *
	 * @param string $id
	 */
	public function view($id = null) {
		$plugin = Plugin::find($id);

		if (empty($plugin)) {
			$this->redirect(array('controller' => 'plugins', 'action' => 'error'));
		}
		if ($this->request->type == 'json') {
			$this->render(array('json' => compact('plugin')));
		}
		return compact('plugin');
	}

	/**
	 * Search
	 *
	 * @param string $word
	 */
	public function search($word = null) {
		if (!$word) {
			$this->redirect(array('controller' => 'plugins', 'action' => 'error'));
		}
		$params = array(
			'conditions' => array(
				'design' => 'search', 'view' => 'words', 'key' => json_encode($word)
			),
			'limit' => 10
		);
		$plugins = Plugin::all($params);

		if ($this->request->type == 'json') {
			$this->render(array('json' => $plugins->to('array')));
		}
		return compact('plugins');
	}

	/**
	 * Temporary controller-based error handler.
	 *
	 * @param string $id
	 * return string Result
	 */
	public function error($id = null) {
		$error = array('type' => 'bad request', 'code' => 500);
		if ($this->request->type == 'json') {
			$this->render(array('json' => compact('error')));
		}
		$this->response->code($error['code']);
		return compact('error');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function add() {
		if (!empty($this->request->data['formula'])) {
			$formula = Formula::create($this->request->data['formula']);
		}
		if (!empty($this->request->data['json'])) {
			$data = json_decode($this->request->data['json']);
			$formula = Formula::create(array(
				'name' => "{$data->name}.json",
				'contents' => $this->request->data['json']
			));
		}
		if (!empty($formula)) {
			if ($formula->save()) {
				$this->request->data = json_decode($formula->contents(), true);
				$this->verify();
			}
		}
		if (empty($plugin)) {
			$plugin = Plugin::create();
		}
		$url = array('plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'add');
		return compact('plugin', 'url');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function verify() {
		if (!empty($this->request->data['verified'])) {
			$plugin = Plugin::create($this->request->data);
			if ($plugin->save()) {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'plugins',
					'action' => 'view', 'args' => array($plugin->id)
				));
			}
		}
		if (empty($plugin)) {
			$plugin = Plugin::create($this->request->data);
		}
		$url = array('plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'verify');
		$this->set(compact('plugin', 'url'));
		$this->render('verify');
	}
}

?>