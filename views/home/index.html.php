<h1 class="home">Lithium Laboratory</h1>
<h2>latest plugins</h2>
<ul>
<?php if (!empty($latestPlugins)) { ?>
<?php		foreach ($latestPlugins as $plugin) { ?>
	<li>
		<?php 
		echo $this->html->link(
			$plugin->name, 
			array(
				'plugin' => 'li3_lab',
				'controller' => 'plugins',
				'action' => 'view',
				'args' => ($plugin->id)
			)
		);
		?></li>
<?php		} ?>
<?php	} ?>
</ul>

<h2>latest extensions</h2>
<ul>
<?php if (!empty($latestExtensions)) { ?>
<?php		foreach ($latestExtensions as $extension) { ?>
	<li>
		<?php 
		echo $this->html->link(
			$extension->class, 
			array(
				'plugin' => 'li3_lab',
				'controller' => 'extensions',
				'action' => 'view',
				'args' => ($extension->id)
			)
		);
		?></li>
<?php		} ?>
<?php	} ?>
</ul>
