<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

/**
 * This model is used to store Couch design views to the `Plugin` database
 * It also defines it. Do not call a 'find' on this model. To view the view, use
 * the 'design' condition in a 'find' call on the `Plugin` model, ie :
 * {{{
 *		$latest = Plugin::find('all', array(
 *          'conditions' => array('design' => 'latest', 'view' => 'all'), 'limit' => 10
 *		));
 * }}}
 *
 * When the find call in the example above returns a NULL, that means the view does not
 * exist in the `Plugin` database. To insert it use:
 * {{{
 *		LabView::init()->save();
 * }}}
 */
class LabView extends \lithium\data\Model {

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
	public static $views = array(
		'latest' => array(
			'id' => '_design/latest',
			'language' => 'javascript',
			'views' => array(
				'all' => array(
					'map' => 'function(doc) {
						emit(doc.created, doc);
					}'
				),
				'plugins' => array(
					'map' => 'function(doc) {
						if (doc.type == "plugins") {
							emit(doc.created, doc);
						}
					}'
				),
				'extensions' => array(
					'map' => 'function(doc) {
						if (doc.type == "extensions") {
							emit(doc.created, doc);
						}
					}'
				)
			)
		),
		'by_field' => array(
			'id' => '_design/by_field',
			'language' => 'javascript',
			'views' => array(
				'name' => array(
					'map' => 'function(doc) {
						emit(doc.name, doc);
					}'
				)
			)
		)
	);

	/**
	 * Create a LabView instance of `Document`. Takes a string name of a predefined design view.
	 *
	 * @param string $data 'latest' is only valid and default
	 * @return Document
	 */
	public static function init($data = 'latest') {
		if (!isset(static::$views[$data])) {
			return false;
		}
		return parent::create(static::$views[$data]);
	}
}

?>