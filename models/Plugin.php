<?php

namespace app\models;

use \lithium\util\Validator;
use \lithium\data\Connections;

class Plugin extends \lithium\core\StaticObject {

	/**
	 * public name of the model
	 *
	 * @var string
	 */
	public static $alias = 'Plugin';

	/**
	 * Metadata
	 *
	 * @var array Meta data to link the model with the couchdb datasource
	 *		- source : the name of the table (called database in couchdb)
	 */
	protected static $_meta = array('source' => 'plugins');

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
	* Validates author, content, language, permanent
	*
	* @return stdClass
	*/
	public static function validate($data) {
		if (!Validator::isNotEmpty($data->maintainer)) {
			$data->errors['maintainer'] = 'You must specify a maintainer.';
		}
		if (!Validator::email($data->maintainer_email)) {
			$data->errors['maintainer_email'] = 'You must specify a valid maintainer email address.';
		}
		if (!Validator::isNotEmpty($data->version)) {
			$data->errors['version'] = 'You must specify a version number for this plugin.';
		}
		if (!Validator::isNotEmpty($data->name)) {
			$data->errors['name'] = 'You must specify a name for this plugin.';
		}
		if (!Validator::isNotEmpty($data->summary)) {
			$data->errors['name'] = 'You must specify a short summary for this plugin.';
		}
		/* @todo add custom regexes for git-based urls */
		if (!Validator::isNotEmpty($data->source)) {
			$data->errors['source'] = 'You must specify a source for this plugin.';
		}
		return $data;
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
	public static function find($view = 'all', $options = array()) {
		$couch = Connections::get('couch');
		$data = $couch->get(static::$_meta['source'].'/_all_docs', $options);

		$isError = (isset($data->error) && $data->error == 'not_found');

		if ($isError && $data->reason == 'no_db_file')  {
			$couch->put(static::$_meta['source']);
			return null;
		}
		return $data;
	}

	/**
	 * Simple search
	 */
	public static function findByWord($word, $options = array()) {
		$couch = Connections::get('couch');
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