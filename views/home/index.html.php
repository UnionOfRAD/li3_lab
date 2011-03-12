
<?php $this->title('Home');?>

<div class="column latest-plugins">
	<h2>
	<?php echo $this->html->link('Latest Plugins', array(
		'controller' => 'li3_lab.Plugins',
		'action' => 'index'
	)); ?>
	</h2>
	<?php if (!empty($latestPlugins)) { ?>
	<ul>
	<?php foreach ($latestPlugins as $plugin) { ?>
		<li>
			<?php echo $this->html->link($plugin->name, array(
					'controller' => 'li3_lab.Plugins',
					'action' => 'view',
					'args' => ($plugin->id)
			));?>
		</li>
	<?php } ?>
		<li>
			<?php echo $this->html->link('view all plugins', array(
				'controller' => 'li3_lab.plugins',
				'action' => 'index'
			)); ?>
		</li>
	</ul>
	<?php } ?>
</div>

<div class="column latest-extensions">
	<h2>
	<?php echo $this->html->link('Latest Extensions', array(
		'controller' => 'li3_lab.Extensions',
		'action' => 'index',
		'args' => array()
	)); ?>
	</h2>
	<?php if ($latestExtensions) { ?>
	<ul>
	<?php foreach ($latestExtensions as $extension) { ?>
		<li>
			<?php echo $this->html->link($extension->name, array(
				'controller' => 'li3_lab.Extensions',
				'action' => 'view',
				'args' => ($extension->id)
			)); ?>
		</li>
	<?php } ?>
		<li>
			<?php echo $this->html->link('view all extensions', array(
				'controller' => 'li3_lab.Extensions',
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