<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

/**
 *
 */
class ExtensionView extends \lithium\data\Model {

	/**
	 * Metadata
	 *
	 * @var array Meta data to link the model with the couchdb datasource
	 *		- source : the name of the table (called database in couchdb)
	 */
	protected $_meta = array('source' => 'li3_lab_extensions', 'connection' => 'li3_lab');


	/**
	 * Predefined views. Only used to store in db if not already there.
	 */
	public static $views = array(
		'latest' => array(
			'id' => '_design/latest',
			'language' => 'javascript',
			'views' => array(
				'all' => array(
					'map' => 'function(doc) {
						emit(doc.created, doc);
					}'
				)
			)
		),
		'search' => array(
            '_id' => '_design/search',
            'language' => 'javascript',
            'views' => array(
                'words' => array(
					'map' => 'function(doc) {
						var txt = doc.name + " " + doc.summary + " " + doc.description;
						var words = txt.replace(/[!.,;]+/g,"").replace(/[\n\r]+/g, " ").toLowerCase().split(" ");
						var cache = {};
						for (var word in words) {
							if (word.length !== 0) {
								emit(words[word], doc);
							}
						}
					}',
                )
            )
        )
	);

	/**
	 * Create a PluginView instance of Document
	 * Unlike Model::create, this takes a string name of a predefined design view
	 *
	 * @param string $data 'lastest' is only valid and default
	 * @return Document
	 */
	public static function create($data = 'latest') {
		if (!isset(static::$views[$data])) {
			return false;
		}
		return parent::create(static::$views[$data]);
	}
}

?>