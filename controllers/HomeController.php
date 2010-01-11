<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\controllers;

use \li3_lab\models\Plugin;
use \li3_lab\models\Extension;

/**
 * Home Page Controller
 *
 */
class HomeController extends \lithium\action\Controller {

	/**
	 * Index
	 */
	public function index() {
		$pluginParams = array(
			'conditions'=> array('design' => 'latest', 'view' => 'all'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latestPlugins = Plugin::all($pluginParams);
		
		$extensionParams = array(
			'conditions'=> array('design' => 'latest', 'view' => 'all'),
			'order' => array('descending' => 'true'),
			'limit' => '10',
		);
		$latestExtensions = Extension::all($extensionParams);
		return compact('latestPlugins','latestExtensions');
	}

}

?>
