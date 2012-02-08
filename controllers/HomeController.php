<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \li3_lab\models\Plugins;
use \li3_lab\models\Extensions;

/**
 * Home Page Controller.
 */
class HomeController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$pluginParams = array(
			'conditions'=> array('design' => 'latest', 'view' => 'plugins'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latestPlugins = Plugins::all($pluginParams);

		$extensionParams = array(
			'conditions'=> array('design' => 'latest', 'view' => 'extensions'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latestExtensions = Extensions::all($extensionParams);
		$home = true;
		return compact('latestPlugins','latestExtensions', 'home');
	}

}

?>
