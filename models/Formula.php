<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\models;

use \lithium\util\Inflector;
use \lithium\util\Validator;

class Formula extends \lithium\core\StaticObject {
	
	/**
	 * undocumented 
	 *
	 */
	public static $path = null;

	/**
	 * undocumented variable
	 *
	 * @var string
	 */
	public static $validates = array(
		// 'name' => array('/\W-/',
		// 			'message' => 'The name can only contain letters, numbers, and "_"'
		// 		),
	);
	/**
	 * undocumented function
	 *
	 * @param string $options
	 * @return void
	 */
	public static function __init($options = array()) {
		parent::__init($options);
		static::$path = LITHIUM_APP_PATH . '/resources/formulas';
		if (!is_dir(static::$path)) {
			mkdir(static::$path);
		}
	}

	/**
	 * undocumented function
	 *
	 * @param string $data
	 * @return void
	 */
	public static function save($data) {
		$errors = Validator::check($data, static::$validates);
		if (empty($errors)) {
			$filename = $data['name'];
			$contents = file_get_contents($data['tmp_name']);
			$formula = static::$path . '/' . $filename;
			if (file_put_contents($formula, $contents)) {
				$replace = array("\r\n", "\n", "\t");
				return json_decode(str_replace($replace, '', $contents), true);
			}
			return false;
		}
	}

}

?>