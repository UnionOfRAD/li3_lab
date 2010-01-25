<h2>Available plugins</h2>
<ul>
<?php

foreach ($latest as $plugin) :
	echo '<li>' . $this->Html->link($plugin->name, array(
		 'plugin' => 'li3_lab',	'controller' => 'plugins',
		'action' => 'view', 'args' => array($plugin->id)
	))  . '</li>';
endforeach;

?>
</ul>