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
	 *
	 * @param string $id
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

	public function add() {
		if (empty($this->request->data)) {
			$extension = Extension::create();
		} else {
			$extension = Extension::create($this->request->data);
			if ($extension->save()) {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'));
			}
		}
		$url = array('plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'add');
		$this->set(compact('url', 'extension'));
		$this->render('form');
	}

	/**
	 *
	 * @param string $id
	 */
	public function edit($id = null) {
		if (empty($this->request->data)) {
			$conditions = array('id' => $id);
			$extension = Extension::find('first', compact('conditions'));
			if (isset($extension->error) && $extension->error == 'not_found') {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'
				));
			}
		} else {
			$extension = Extension::find($this->request->data['id']);
			if (isset($extension->error) && $extension->error == 'not_found') {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'
				));
			} elseif ($extension->save($this->request->data)) {
				$this->redirect(array(
					'plugin' => 'li3_lab', 'controller' => 'extensions','action' => 'index'
				));
			}
		}
		$url = array(
			'plugin' => 'li3_lab', 'controller' => 'extensions',
			'action' => 'edit', 'args' => array($extension->id)
		);
		$this->set(compact('extension', 'url'));
		$this->render('form');
	}
}

?>