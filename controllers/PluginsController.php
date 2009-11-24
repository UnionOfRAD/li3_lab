<?php

namespace app\controllers;

use \app\models\Plugin;
use \lithium\util\Set;

/**
 * Plugin controller
 *
 */
class PluginsController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$data = Plugin::find('all', array('include_docs' => 'true'));

		$plugins = array();
		foreach($data->rows as $row) {
			if (!$row->doc->views) {
				$plugins[] = $row->doc;
			}
		}
		$this->render(array('json' => compact('plugins')));
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
}
?>