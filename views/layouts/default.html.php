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
	<?=@$this->html->charset(); ?>
	<title>Li3 Paste Bin</title>
	<?=@$this->html->style('bin'); ?>
	<?=@$this->scripts(); ?>
	<?=@$this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?=@$this->html->script(array('jquery-1.3.2.min.js', 'ZeroClipboard.js', 'bin.js')); ?>
	<?php
		if (!empty($paste->language)) {
			echo $this->html->style('syntax.' . $paste->language);
		}?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?=@$this->html->image('lithium-logo.png');?>
			<div id="menu">
				<ul >
					<li><?=@$this->html->link('Add new', array('controller'=>'pastes', 'action' => 'add'));?></li>
					<li><?=@$this->html->link('Latest', array('controller'=>'pastes', 'action' => 'index'));?></li>
				</ul>
			</div>
		</div>
		<div id="content">
			<?=@$this->content; ?>
		</div>
		<div id="footer">
			@2009 Union of Rad
		</div>
	</div>
</body>
</html>