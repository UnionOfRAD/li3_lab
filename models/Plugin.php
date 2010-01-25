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
	protected $_meta = array('source' => 'li3_lab', 'connection' => 'li3_lab');

	/**
	 * validation rules
	 *
	 * @var string
	 */
	public $validates = array(
		'name' => array(
			array('notEmpty', 'message' => 'You must specify a name for this plugin.'),
			array('isUnique', 'message' => 'Name must be unique.')
		),
		'version' => 'You must specify a version for this plugin.',
		'summary' => 'You must specify a short summary for this plugin',
		'sources' => array(
			'isSource', 'types' => array('git', 'phar'),
			'message' => 'You must specify a source for this plugin.'
		)
	);

	public static function __init($options = array()) {
		parent::__init($options);
		static::applyFilter('save', function($self, $params, $chain) {
			$params['record']->type = 'plugins';
			if (isset($params['record']->created)) {
				$params['record']->modified = date('Y-m-d h:i:s');
			} else {
				$params['record']->created = date('Y-m-d h:i:s');
			}
			return $chain->next($self, $params, $chain);
		});
		Validator::add('isSource', function ($data, $params, $options) {
			foreach ($data as $type => $source) {
				if (in_array($type, $options['types'])) {
					return true;
				}
				return false;
			}
		});
		$self = static::_instance();
		Validator::add('isUnique', function ($data, $params, $options) use ($self){
			$plugin = $self::find('first', array(
				'conditions' => array(
					'design' => 'by_field', 'view' => 'name',
					'key' => json_encode($data)
				)
			));
			if (!empty($plugin->name)) {
				return false;
			}
			return true;
		});
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