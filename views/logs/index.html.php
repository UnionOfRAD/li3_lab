<ul>
	<?php foreach ($logs as $date) {
		if (!preg_match("/(.*?)-(.*?)-(.*?)/", $date)) continue; ?>
		<li><a href="<?php echo $date; ?>"><?php echo $date; ?></a></li>
	<?php } ?>
</ul>
