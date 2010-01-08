<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \li3_lab\models\Extension;
use \li3_lab\models\ExtensionView;

/**
 *  Extensions Controller
 *
 */
class ExtensionsController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$params = array(
			'conditions'=> array('design' => 'latest', 'view' => 'all'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latest = Extension::all($params);
		if ($this->request->type == 'json') {
			$this->render(array('json' => $latest->to('array')));
		}
		return compact('latest');
	}

	/**
	 * View
	 */
	public function view($id = null) {
		$conditions = array('id' => $id, 'revs' => 'true');
		if (!empty($this->request->data)) {
			$conditions['rev'] = $this->request->data['revision'];
		}
		$extension = Extension::find('first', compact('conditions'));

		if (empty($extension)) {
			$this->redirect(array('controller' => 'extensions', 'action' => 'error'));
		}
		if ($this->request->type == 'json') {
			$this->render(array('json' => compact('extension')));
		}
		return compact('extension');
	}

	/**
	 * Search
	 */
	public function search($word = null) {
		if (!$word) {
			$this->redirect(array('controller' => 'extensions', 'action' => 'error'));
		}
		$params = array(
			'conditions' => array(
				'design' => 'search', 'view' => 'words', 'key' => json_encode($word)
			),
			'limit' => 10
		);
		$extensions = Extension::all($params);

		if ($this->request->type == 'json') {
			$this->render(array('json' => $extensions->to('array')));
		}
		return compact('extensions');
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

	public function add() {
		if (!empty($this->request->data)) {
			$extension = Extension::create($this->request->data);
			if ($extension->save()) {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'));
			}
		}
		$this->render('form');
	}

	public function edit($id = null) {
		if (empty($this->request->data)) {
			$conditions = array('id' => $id);
			$extension = Extension::find('first', compact('conditions'));
			if (isset($extension->error) && $extension->error == 'not_found') {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'));
			}
		} else {
			$extension = Extension::find($this->request->data['id']);
			if (isset($extension->error) && $extension->error == 'not_found') {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'));
			} elseif ($extension->save($this->request->data)) {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'));
			}
		}
		$this->set(compact('extension'));
		$this->render('form');
	}

}
?>