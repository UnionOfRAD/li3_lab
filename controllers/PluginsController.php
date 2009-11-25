<?php

namespace li3_lab\controllers;

use \lithium\data\Connections;
use \li3_lab\models\Plugin;
use \li3_lab\models\PluginView;

/**
 * Plugin controller
 *
 */
class PluginsController extends \lithium\action\Controller {

	protected function _init() {
		parent::_init();
		Connections::add('li3_lab', 'http', array('adapter' => 'CouchDb', 'port' => 5984));
	}

	/**
	 * Index
	 */
	public function index() {
		$params = array(
			'conditions'=> array(
				'design' => 'latest', 'view' => 'all', 'descending' => 'true'
			),
			'limit' => '10',
		);
		$latest = Plugin::all($params);
		if ($latest === null) {
			if (PluginView::create()->save()) {
				$latest = Plugin::all($params);
			}
		}
		$this->render(array('json' => $latest->to('array')));
	}

	/**
	 * View
	 */
	public function view($id = null) {
		$plugin = Plugin::find($id);

		if (empty($plugin)) {
			$this->redirect(array('controller' => 'plugins', 'action' => 'error'));
		}
		return $this->render(array('json' => compact('plugin')));
	}

	/**
	 * Search
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
		if (empty($plugins[0])) {

			if (PluginView::create('search')->save()) {
				$plugins = Plugin::all($params);
			}
		}
		$this->render(array('json' => $plugins->to('array')));
	}

	/**
	 * Temporary controller-based error handler.
	 *
	 * @param string $id
	 * return string Result
	 */
	public function error($id = null) {
		$error = array('type' => 'bad request', 'code' => 500);
		return $this->render(array('json' => compact('error')));
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function add() {
		if (!empty($this->request->data)) {
			$plugin = Plugin::create($this->request->data);
			if ($plugin->validates() && $plugin->save()) {
				$this->redirect(array(
					'plugin' => 'li3_bot',
					'controller' => 'plugins', 'action' => 'view', 'args' => array($plugin->id)
				));
			}
		}
		if (empty($plugin)) {
			$plugin = Plugin::create();
		}

		$this->set(compact('plugin'));
		$this->render('form');
	}
}
?>