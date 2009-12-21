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
	<title>Li3 Plugins</title>
	<?=$this->scripts(); ?>
	<?=$this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?=$this->html->style('base')?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Li3 Plugins</h1>
			<div id="menu">
				<ul >
					<li><?php echo $this->html->link('Add new', array(
						'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'add'
					));?></li>
					<li><?php echo $this->html->link('Latest', array(
						'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'index'
					));?></li>
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
</body>
</html>