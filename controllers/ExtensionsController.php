<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use li3_lab\models\Extension;

/**
 *  Extensions Controller
 *
 */
class ExtensionsController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$latest = Extension::all(array(
			'conditions'=> array('design' => 'latest', 'view' => 'extensions'),
			'order' => array('descending' => 'true'),
			'limit' => '10'
		));
		return compact('latest');
	}

	/**
	 * View
	 *
	 * @param string $id
	 */
	public function view($id = null) {
		$conditions = array('id' => $id, 'revs' => 'true');

		if ($this->request->data) {
			$conditions['rev'] = $this->request->data['revision'];
		}
		$extension = Extension::find('first', compact('conditions'));

		if (!$extension) {
			return $this->redirect(array('controller' => 'extensions', 'action' => 'error'));
		}
		if ($this->request->type == 'json') {
			$this->render(array('json' => compact('extension')));
		}
		return compact('extension');
	}

	public function add() {
		$extension = Extension::create();

		if ($this->request->data && $extension->save($this->request->data)) {
			$this->redirect(array('library' => 'li3_lab', 'Extensions::index'));
		}
		$url = array('library' => 'li3_lab', 'Extensions::add');
		$this->render(array('template' => 'form', 'data' => compact('url', 'extension')));
	}

	/**
	 *
	 * @param string $id
	 */
	public function edit($id = null) {
		if ((!$id) || !($extension = Extension::first($id))) {
			return $this->redirect(array('library' => 'li3_lab', 'Extensions::index'));
		}

		if ($this->request->data && $extension->save($this->request->data)) {
			return $this->redirect(array('library' => 'li3_lab', 'Extensions::index'));
		}
		$url = array('library' => 'li3_lab', 'Extensions::edit', 'args' => array($extension->id));
		$this->render(array('template' => 'form', 'data' => compact('extension', 'url')));
	}
}

?>