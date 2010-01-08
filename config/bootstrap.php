<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\data\Connections;

Connections::add('li3_lab', 'http', array(
	'adapter' => 'CouchDb',
	'host' => '127.0.0.1',
	'port' => '5984'
));

Connections::add('resources', 'Media', array('path' => '/resources'));

?>