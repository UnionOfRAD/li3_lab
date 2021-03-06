<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

/**
 * Used to store uploaded phar archives
 *
 * @package default
 */
class Repo extends \lithium\data\Model {

	protected $_meta = array('connection' => 'resources');
}

?>