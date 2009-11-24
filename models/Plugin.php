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
	 * Document Views
	 *
     * Contain all map/reduce views for couchdb
	 * @todo add view for basic search
	 * @todo add view for sorting by most recently updated/added
	 */
    protected static $_views = array(
        'search' => array(
            '_id' => '_design/search',
            'language' => 'javascript',
            'views' => array(
                'search' => array(
					'map' => 'function(doc) {
						var txt = doc.name + " " + doc.summary + " " + doc.description;
						var words = txt.replace(/[!.,;]+/g,"").replace(/[\n\r]+/g, " ").toLowerCase().split(" ");
						for (var word in words) {
							if (word.length !== 0) {
								emit(words[word], doc);
							}
						}

					}'
                )
            )
        )
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
				if (!empty($params['rule'])) {
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

	/**
	 * Find and return a dataobject for the given $id
	 * will parse data unless given option 'parsed' => false
	 *
	 * @param string $id uuid of the document for this paste
	 * @param array $options Valid keys are:
	 *		- parsed: A bool that if true will return geshi parsed code
	 * @return stdClass dataobject if found, null if
	 */
	public static function findFirstById($id) {
		$result = Connections::get('couch')->get(static::$_meta['source'].'/'.$id);
		return (!isset($result->error)) ? $result : null;
	}

	/**
	 * Find
	 */
	// public static function find($view = 'all', $options = array()) {
	// 	$couch = Connections::get('couch');
	// 	$data = $couch->get(static::$_meta['source'].'/_all_docs', $options);
	//
	// 	$isError = (isset($data->error) && $data->error == 'not_found');
	//
	// 	if ($isError && $data->reason == 'no_db_file')  {
	// 		$couch->put(static::$_meta['source']);
	// 		return null;
	// 	}
	// 	return $data;
	// }

	/**
	 * Simple search
	 */
	public static function findByWord($word, $options = array()) {
		$couch = Connections::get('li3_lab');
		$path = static::$_meta['source'] . '/' . static::$_views['search']['_id'];
		$data = $couch->get($path . '/_view/search?key="'.$word.'"', $options);

		$isError = (isset($data->error) && $data->error == 'not_found');

		if ($isError && $data->reason == 'no_db_file')  {
			$couch->put(static::$_meta['source']);
			return null;
		}
		if ($isError && in_array($data->reason, array('missing', 'deleted')))  {
			$create = $couch->put($path, static::$_views['search']);
			$data = $couch->get($path . '/_view/search?key="'.$word.'"', $options);
		}
		return $data;

	}
}
?>