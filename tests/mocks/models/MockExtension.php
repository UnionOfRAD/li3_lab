<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\mocks\models;

class MockExtension extends \li3_lab\models\Extension {

	protected $_classes = array(
	  'query' => '\lithium\data\model\Query',
	  'record' => '\lithium\data\model\Document',
	  'validator' => '\lithium\util\Validator',
	  'recordSet' => '\lithium\data\model\Document',
	  'connections' => '\lithium\data\Connections'
	);

	protected $_schema = array(
		'name' => array('default' => null, 'type' => 'string'),
		'summary' => array('default' => null, 'type' => 'string'),
		'description' => array('default' => null, 'type' => 'string'),
		'maintainers' => array('default' => null, 'type' => 'list'),
		'code' => array('default' => null, 'type' => 'string'),
		'created' 	=> array('default' => '1979-01-01 01:01:01', 'type' => 'string')
	);

	protected $_meta = array();

	public function classes() {
		return $this->_classes;
	}

	public static $mockData = array(
		'name' => 'MockExtension model',
		'summary' => 'Pretend model for testing purposes',
		'description' => 'Contains mock setup and data for testing the Extension model.',
		'maintainers' => array('email' => 'john@example.org'),
		'code' => '<?php

namespace li3_lab\tests\mocks\models;

class MockExtension extends \li3_lab\models\Extension {
	protected $_meta = array();
}'
	);

	public static function __init($options = array()) {
		parent::__init($options);
		MockExtension::applyFilter('save', function($self, $params, $chain) {
			$params['record']->created = date('Y-m-d h:i:s');
			return $chain->next($self, $params, $chain);
		});
	}
}

?>