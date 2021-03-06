<?php

namespace li3_lab\extensions\command;

use \li3_lab\models\Plugin;
use \li3_lab\models\Extension;
use \li3_lab\models\LabView;

/**
 * Command to assist in setup and management of Lithium Bin
 *
 */
class Server extends \lithium\console\Command {

	/**
	 * Run the install method to create database and views
	 *
	 * @return boolea
	 */
	public function install() {
		$this->header('Lithium Lab Server');
		$result = Plugin::install();
		$result = $result && Extension::install();

		foreach (array_keys(LabView::$views) as $view) {
			LabView::init($view)->save();
			$this->_check('\li3_lab\models\LabView', $view);
		}
	}

	protected function _check($model, $name = null) {
		if (!$name) {
			return null;
		}

		$view = $model::find("_design/{$name}");

		if (!empty($view->reason)) {
			switch($view->reason) {
				case 'no_db_file':
					$this->out(array(
						'Database does not exist.',
						'Please make sure CouchDB is running and refresh to try again.'
					));
				break;
				case 'missing':
					$this->out(array(
						'Database created.', 'Design views were not created.',
						'Please run the command again.'
					));
				break;
			}
		}
		if (isset($view->id) && $view->id == "_design/{$name}") {
			$this->out("{$model} {$name} view created.");
			return true;
		}
	}
}

?>