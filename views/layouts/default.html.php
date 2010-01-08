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
	<style>
		#extension h2 {
			color: pink;
			margin-bottom: 0;
		}
		#extension h3 {
			margin:0 0 1em; padding: 0;
			font-size:small;
			color: #666;
		}
		#extension p.summary {
			margin: 0 0 1em; padding: 0;
			font-weight: bold;
		}
		#extension div.description {
			margin-bottom: 2em;
		}
	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Li3 Lab</h1>
			<div id="menu">
				<ul style="margin:0 0 15px 0;">
					<li style="display:inline;">
						<?php echo $this->html->link('Add new Plugin', array(
						'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'add'
					));?></li>
					<li style="display:inline;"> | </li>
					<li style="display:inline;">
						<?php echo $this->html->link('Latest Plugins', array(
						'plugin' => 'li3_lab', 'controller' => 'plugins', 'action' => 'index'
					));?></li>
					<li style="display:inline;"> | </li>
					<li style="display:inline;">
						<?php echo $this->html->link('Add new Extension', array(
						'plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'add'
					));?></li>
					<li style="display:inline;"> | </li>
					<li style="display:inline;">
						<?php echo $this->html->link('Latest Extensions', array(
						'plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'index'
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