<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\data\Connections;

Connections::add('li3_lab', array(
	'type' => 'http',
	'adapter' => 'CouchDb',
	'host' => 'localhost',
	'port' => 5984,
	'database' => 'li3_lab'
));

Connections::add('resources', array(
	'type' => 'Media',
	'path' => '/resources'
));

?>