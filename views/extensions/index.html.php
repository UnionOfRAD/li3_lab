<h2>Available Extensions</h2>
<ul>
<?php

foreach ($latest as $ext) :
	echo '<li>' . $this->Html->link($ext->class, array(
		 'plugin' => 'li3_lab',	'controller' => 'extensions',
		'action' => 'view', 'args' => array($ext->id)
	))  . '</li>';

endforeach;

?>
</ul>