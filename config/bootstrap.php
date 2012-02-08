<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\data\Connections;

/**
 * Database connection for the Lab.
 */
Connections::add('li3_lab', array(
	'type' => 'MongoDb',
	'hostname' => 'localhost',
	'database' => 'li3_lab'
));

/**
 * Configure an additional resource to use.
 */
Connections::add('resources', array(
	'type' => 'Media',
	'path' => '/resources'
));

?>