<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\http\Router;

Router::connect('/lab/{:controller}/{:action}', array(
	'plugin' => 'li3_lab', 'controller' => 'plugins'
));
Router::connect('/lab/{:controller}/{:action}/{:args}', array(
	'plugin' => 'li3_lab', 'controller' => 'plugins'
));

?>