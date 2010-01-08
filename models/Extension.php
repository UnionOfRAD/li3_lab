<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

use \lithium\util\Validator;

class Extension extends \lithium\data\Model {

	/**
	 * public name of the model
	 *
	 * @var string
	 */
	public $alias = 'Extension';

	/**
	 * Metadata
	 *
	 * @var array Meta data to link the model with the couchdb datasource
	 *		- source : the name of the table (called database in couchdb)
	 */
	protected $_meta = array('source' => 'li3_lab_extensions', 'connection' => 'li3_lab');

	/**
	 * validation rules
	 *
	 * @var string
	 */
	public $validates = array(
		'name' => 'You must specify a name for this plugin.',
		'summary' => 'You must specify a short summary for this plugin'
	);
/*
	public static function __init($options = array()) {
		parent::__init($options);
	}
*/
	/**
	 * undocumented function
	 *
	 * @param string $data
	 * @return void
	 */
	public static function create($data = array()) {
		if (!isset($data['created'])) {
			$data['created'] = date('Y-m-d h:i:s');
		}
		return parent::create($data);
	}

	/**
	 * Creates a new database
	 *
	 * @return void
	 */
	public static function install() {
		return \lithium\data\Connections::get(static::meta('connection'))->put(static::meta('source'));
	}
}
?>