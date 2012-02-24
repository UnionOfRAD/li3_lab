<?php
/**
 * Li3 Lab: consume and distribute plugins for the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_lab\tests\mocks\models;

class MockPlugin extends \li3_lab\models\Plugin {

	protected $_meta = array('source' => 'test_li3_lab', 'connection' => 'test_li3_lab');
}

?>