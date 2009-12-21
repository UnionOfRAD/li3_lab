<h2>Available plugins</h2>
<ul>
<?php

foreach ($latest as $plugin) :
	echo "<li>{$plugin->name}</li>";

endforeach;

?>
</ul>