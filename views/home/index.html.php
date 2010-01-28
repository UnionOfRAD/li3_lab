<div class="column latest-plugins">
	<h2>
	<?php echo $this->html->link('Latest Plugins', array(
		'plugin' => 'li3_lab',
		'controller' => 'plugins',
		'action' => 'index'
	)); ?>
	</h2>
	<?php if (!empty($latestPlugins)) { ?>
	<ul>
	<?php foreach ($latestPlugins as $plugin) { ?>
		<li>
			<?php echo $this->html->link($plugin->name, array(
					'plugin' => 'li3_lab',
					'controller' => 'plugins',
					'action' => 'view',
					'args' => ($plugin->id)
			));?>
		</li>
	<?php } ?>
		<li>
			<?php echo $this->html->link('view all plugins', array(
				'plugin' => 'li3_lab',
				'controller' => 'plugins',
				'action' => 'index'
			)); ?>
		</li>
	</ul>
	<?php } ?>
</div>

<div class="column latest-extensions">
	<h2>
	<?php echo $this->html->link('Latest Extensions', array(
		'plugin' => 'li3_lab',
		'controller' => 'extensions',
		'action' => 'index'
	)); ?>
	</h2>
	<?php if (!empty($latestExtensions)) { ?>
	<ul>
	<?php foreach ($latestExtensions as $extension) { ?>
		<li>
			<?php echo $this->html->link($extension->name, array(
					'plugin' => 'li3_lab',
					'controller' => 'extensions',
					'action' => 'view',
					'args' => ($extension->id)
			));?>
		</li>
	<?php } ?>
		<li>
			<?php echo $this->html->link('view all extensions', array(
				'plugin' => 'li3_lab',
				'controller' => 'extensions',
				'action' => 'index'
			)); ?>
		</li>
	</ul>
	<?php } ?>

</div>

<div class="column news">
	<h2>Laboratory News</h2>
	<p>No news at this time...</p>
</div>