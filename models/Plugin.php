<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

use \lithium\util\Validator;
use \lithium\data\Connections;

class Plugin extends \lithium\data\Model {

	/**
	 * public name of the model
	 *
	 * @var string
	 */
	public $alias = 'Plugin';

	/**
	 * Metadata
	 *
	 * @var array Meta data to link the model with the couchdb datasource
	 *		- source : the name of the table (called database in couchdb)
	 */
	protected $_meta = array('source' => 'li3_lab_plugins', 'connection' => 'li3_lab');

	/**
	 * validation rules
	 *
	 * @var string
	 */
	public $validates = array(
		'name' => 'You must specify a name for this plugin.',
		'version' => 'You must specify a version for this plugin.',
		'summary' => 'You must specify a short summary for this plugin',
		'sources' => array('isSource', 'message' => 'You must specify a source for this plugin.')
	);

	public static function __init($options = array()) {
		parent::__init($options);
		Validator::add('isSource', function ($data, $params, $options) {
			$types = array('git', 'phar');
			foreach ($data as $type => $source) {
				if (in_array($type, $types)) {
					return true;
				}
			}
		});
	}

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
		return Connections::get(static::meta('connection'))->put(static::meta('source'));
	}
}

?>