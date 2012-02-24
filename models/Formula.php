<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

class Formula extends \lithium\data\Model {

	/**
	 * Meta configuration
	 *
	 */
	public $_meta = array('connection' => 'resources');

	/**
	 * undocumented variable
	 *
	 * @var string
	 */
	public $validates = array(
		// 'name' => array('/\W-/',
		// 			'message' => 'The name can only contain letters, numbers, and "_"'
		// 	),
	);
}

?>