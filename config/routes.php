<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\net\http\Router;

Router::connect('/lab', array(
	'library' => 'li3_lab', 'controller' => 'home', 'action' => 'index'
));

Router::connect('/lab/{:args}.json', array(
	'library' => 'li3_lab', 'controller' => 'plugins', 'action' => 'view', 'type' => 'json'
));

Router::connect('/lab/download/{:args}.phar.gz', array(
	'library' => 'li3_lab', 'controller' => 'plugins', 'action' => 'download'
));

Router::connect('/lab/{:controller}/{:action}/{:args}', array(
	'library' => 'li3_lab', 'controller' => 'home'
));

?>