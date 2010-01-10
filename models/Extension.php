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
	 * @var array
	 */
	public $validates = array(
		'name' => 'You must specify a name.',
		'summary' => 'You must specify a short summary.',
		'description' => 'You must specify a longer description.',
		'maintainers' => array(
			'validMaintainer',
			'message' => 'Must specify at least one with at least an email.'
		),
		'code' => array('validCode', 'message' => 'Must be a class with a namespace.')
	);

	public static function __init($options = array()) {
		parent::__init($options);
		static::applyFilter('save', function($self, $params, $chain) {
			$params['record']->created = date('Y-m-d h:i:s');
			$params['record']->namespace = $self::parseNamespace($params['record']->code);
			$params['record']->class = $self::parseClass($params['record']->code);
			$params['record']->file =
				str_replace("\\", "/", $params['record']->namespace) .
				'/' .
				$params['record']->class .
				'.php';
			return $chain->next($self, $params, $chain);
		});
		Validator::add('validMaintainer', function ($value, $format, $options) {
			$result = false;
			if (is_array($value) && isset($value[0]['email'])) {
				$result = Validator::isEmail($value[0]['email']);
			}
			return $result;
		});
		Validator::add('validCode', function ($value, $format, $options) {
			$namespace = preg_match('/namespace/', $value);
			$class = preg_match('/class/', $value);
			return $namespace && $class;
		});
	}

	public static function parseNamespace($code) {
		$start = strpos($code, 'namespace') + 10;
		$end = strpos($code, ';');
		return substr($code, $start, $end - $start);
	}

	public static function parseClass($code) {
		$start = strpos($code, 'class') + 6;
		$end = strpos($code, ' ', $start);
		return substr($code, $start, $end - $start);
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