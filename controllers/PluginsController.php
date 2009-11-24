<?php

namespace li3_lab\controllers;

use \lithium\data\Connections;
use \li3_lab\models\Plugin;
use \lithium\util\Set;

/**
 * Plugin controller
 *
 */
class PluginsController extends \lithium\action\Controller {

	protected function _init() {
		parent::_init();
		Connections::add('li3_lab', 'http', array('adapter' => 'CouchDb'));
	}

	/**
	 * Index
	 */
	public function index() {
		$data = Plugin::all(array('include_docs' => 'true'));

		$plugins = array();
		// foreach($data->rows as $row) {
		// 		if (!$row->doc->views) {
		// 			$plugins[] = $row->doc;
		// 		}
		// 	}
		var_Dump($plugins);
		die();
		//$this->render(array('json' => compact('plugins')));
	}

	/**
	 * View
	 */
	public function view($id = null) {
		$plugin = Plugin::findFirstById($id);

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
		$plugins = Plugin::findByWord($word->rows);
		return $this->render(array('json' => compact('plugins')));
	}

	/**
	 * Temporary controller-based error handler.
	 *
	 * @param string $id
	 * return string Result
	 */
	public function error($id = null) {
		$error = array('type' => 'bad request', 'code' => 500);
		return $this->render(array('text' => compact('error')));
	}

	public function add() {
		if (!empty($this->request->data)) {
			$plugin = Plugin::create($this->request->data);
			if ($plugin->validates() && $plugin->save()) {
				$this->redirect(array(
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