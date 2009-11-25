<?php

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


	public static $validates = array(
		'maintainer' => 'You must specify a maintainer.',
		'maintainer_email' => array(
			'rule' => 'email',
			'message' => 'You must specify a valid maintainer email address.'
		),
		'version' => 'You must specify a version number for this plugin.',
		'name' => 'You must specify a name for this plugin.',
		'summary' => 'You must specify a short summary for this plugin',
		'source' => 'You must specify a source for this plugin.'
	);

	/**
	 *  Default values for document based db
	 *
	 * @var array
	 */
	protected static $_defaults = array(
		'maintainer' => null,
		'maintainer_email' => null,
		'version' => null,
		'name' => null,
		'summary' => false,
		'description' => false,
		'source' => null,
		'created' => null,
		'updated' => null
	);

	/*
	* Validate the input data before saving to data
	*
	* @param $record Document instance
	* @param $options array
	* @return boolean
	*/
	public function validates($record, $options = array()) {
		return static::_filter(__METHOD__, compact('record', 'options'), function($self, $params) {
			extract($params);
			$errors = array();
			foreach ($self::$validates as $field => $params) {
				$rule = 'isNotEmpty';
				$message = $params;
				$data = array();
				if (is_array($params) && !empty($params['rule'])) {
					var_Dump($params['rule']);
					if (is_string($params['rule'])) {
						$rule = $params['rule'];
					} else {
						$rule = array_shift((array) $params['rule']);
						$data = $params['rule'];
					}
				}

				$data = array($record->{$field}) + $data;
				if (Validator::invokeMethod($rule, $data) !== true) {
					if (!empty($params['message'])) {
						$message = $params['message'];
					}
					$errors[$field] = $message;
				}
			}
			if (empty($errors)) {
				return true;
			}
			$record->set(array('errors' => $errors));
			return false;
		});
	}

	/**
	 * undocumented function
	 *
	 * @param string $data
	 * @return void
	 */
	public static function create($data = array()) {
		$data += static::$_defaults;
		if (!isset($data['created'])) {
			$data['created'] = date('Y-m-d h:i:s');
		}
		return parent::create($data);
	}
}
?>