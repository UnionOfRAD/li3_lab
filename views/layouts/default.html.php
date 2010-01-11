<?php
/**
 * Lithium: the most rad php framework
 * Copyright 2009, Union of Rad, Inc. (http://union-of-rad.org)
 *
 * Licensed under The BSD License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009, Union of Rad, Inc. (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?=$this->html->charset(); ?>
	<title>Li3 Lab</title>
	<?=$this->scripts(); ?>
	<?=$this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?=$this->html->style('base')?>
	<?=$this->html->style('li3_lab')?>
	<?=$this->html->script('li3_lab')?>
	<?=$this->html->script('http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js')?>
</head>
<body>
	<div id="container" <?php echo (! empty($home))? 'class="home"' : null ; ?>
		<div id="header">
			<h1><?php echo $this->html->link('Lithium Laboratory', array(
				'plugin' => 'li3_lab',
				'controller' => 'home',
				'action' => 'index'
			)); ?></h1>
			<div id="menu">
				<ul>
					<li class="add-plugin">
						<?php echo $this->html->link('Add Plugin', array(
							'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'add'
						));?>
					</li>
					<li class="add-extension">
						<?php echo $this->html->link('Add Extension', array(
							'plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'add'
						));?>
					</li>
					<li class="all-plugins">
						<?php echo $this->html->link('View Plugins', array(
							'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'index'
						));?>
					</li>
					<li class="all-extensions">
						<?php echo $this->html->link('View Extensions', array(
							'plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'index'
						));?>
					</li>
				</ul>
			</div>
		</div>
		<div id="content">
			<?php echo $this->content(); ?>
		</div>
		<div id="footer">
			@2009 Union of Rad
		</div>
	</div>

	<?php echo $this->html->script(array(
		'li3_lab', 'http://li3.rad-dev.org/js/li3.console.js'
	)); ?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function () {
			//li3Lab.maintainers();
			li3Console.setup();
		});
	</script>
</body>
</html>
