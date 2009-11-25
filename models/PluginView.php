<?php

namespace li3_lab\models;

/**
 * This model is used to store Couch design views to the `Plugin` database
 * It also defines it. Do not call a 'find' on this model. To view the view, use
 * the 'design' condition in a 'find' call on the `Plugin` model, ie :
 * {{{
 *		$latest = Plugin::find('all', array('conditions' => array(
 *			'design' => 'latest,
 *			'limit' => 10
 *		)));
 * }}}
 *
 * When the find call in the example above returns a NULL, that means the view does not
 * exist in the `Plugin` database. To insert it use:
 * {{{
 *		PluginView::create()->save();
 * }}}
 */
class PluginView extends \lithium\data\Model {

	/**
	 * public name of the model
	 *
	 * @var string
	 */
	public $alias = 'PluginView';

	/**
	 * Metadata
	 *
	 * @var array Meta data to link the model with the couchdb datasource
	 *		- source : the name of the table (called database in couchdb)
	 */
	protected $_meta = array('source' => 'li3_lab', 'connection' => 'li3_lab');


	/**
	 * Predefined views. Only used to store in db if not already there.
	 */
	protected static $_views = array(
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
		if (!isset(static::$_views[$data])) {
			return false;
		}
		return parent::create(static::$_views[$data]);
	}
}

?>