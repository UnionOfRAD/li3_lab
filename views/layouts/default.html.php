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
	<?=$this->html->link('Icon', null, array('type' => 'icon')); ?>

	<?=$this->html->style(array('base', 'http://li3.rad-dev.org/css/li3.css', 'li3_lab'))?>
	<?=$this->html->script(array(
		'http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js',
		'http://li3.rad-dev.org/js/jquery.input_list.js'
	));?>
	<script type="text/javascript"><?=$this->scripts();?></script>

</head>
<body>
	<div id="wrapper">
		<div id="container" class="<?php echo (! empty($home))? 'home' : 'internal' ; ?>">
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
		</div>
	</div>
	<div id="footer">
			<p class="copyright">Pretty much everything is &copy; 2009 and beyond, the Union of Rad</p>
	</div>

	<?php echo $this->html->script(array(
		'http://li3.rad-dev.org/js/li3.console.js'
	)); ?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function () {
			li3Console.setup();
		});
	</script>
</body>
</html>
