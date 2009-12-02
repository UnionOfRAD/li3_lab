<?php

namespace li3_example\config;

class Li3Example {
	
	public $data = array(
		'name' => 'li3_example', 
		'version' => '1.0',
		'summary' => 'a li3 plugin example',
		'created' => '2009-11-30', 'updated' => '2009-11-30',
		'rating' => '9.9', 'downloads' => '1000',
		'maintainers' => array(
			'name' => 'gwoo', 'email' => 'gwoo@nowhere.com', 'website' => 'li3.rad-dev.org'
		),
		'sources' => array(
			'git' => 'git://rad-dev.org/li3_example.git',
			'gz' => 'http://downloads.rad-dev.org/li3_example.tar.gz'
		),
		'requires' => array(
			'li3_lab' => array('version' => '<=1.0')
		)
	);
	
	public function onAdd() {
		
	}
	
	public function onRemove() {
		
	}
}
?>