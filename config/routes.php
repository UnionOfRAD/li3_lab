<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of Rad, Inc. (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\http\Router;

Router::connect('/lab/{:action}/{:args}', array(
	'plugin' => 'li3_lab', 'controller' => 'plugins'
));

?>