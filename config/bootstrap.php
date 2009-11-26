<?php
use \lithium\data\Connections;

Connections::add('li3_lab', 'http', array('adapter' => 'CouchDb', 'port' => 5984));

?>