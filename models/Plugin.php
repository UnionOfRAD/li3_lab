<?php
/**
 * Lithium: the most rad php framework
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


	public $validates = array(
		'maintainer' => 'You must specify at least one maintainer.',
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