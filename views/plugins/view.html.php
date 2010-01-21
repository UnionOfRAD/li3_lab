<div id="plugin">
	<div class="details">
		<h1><?=$plugin->name;?></h1>
		<h2><?=$plugin->summary;?></h2>
		<div class="actions">
			<a href="#">Download</a>
		</div>
	</div>
	<div class="meta">
		<h3>Description</h3>
		<div class="description"><?=$plugin->description;?></div>
		<h3>Details</h3>
		<ul>
			<li>Version: <?php echo (isset($plugin->version)) ?: 1;?></li>
			<li>Created: <?=$plugin->created;?></li>
		</ul>
	<?php if (isset($plugin->maintainers)) {?>
		<h3>Maintainers</h3>
		<ul class="maintainers">
		<?php
			foreach ($plugin->maintainers as $man) {
				$name = (!empty($man->name)) ? $man->name : $man->email;
				if (empty($name)) continue;
				echo '<li><strong>';
				echo $name . '</strong> (<a href="mailto:' . $man->email . '">' . $man->email . '</a>) '
				 . '<a href="http://' . $man->website . '">' . $man->website . '</a>';
				echo '</li>';
			}
		?>
		</ul>
	<?php } else {
		echo '<p>No maintainers set.</p>';
	}?>
	</div>
</div>
