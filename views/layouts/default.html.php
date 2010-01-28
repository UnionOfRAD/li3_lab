<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?=$this->html->charset(); ?>
	<title>Li3 Lab<?php echo (!empty($this->title)) ? " > {$this->title}" : null;?></title>
	<?=$this->html->link('Icon', null, array('type' => 'icon'));?>

	<?=$this->html->style('base');?>

	<?=$this->html->script(array(
		'http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js',
		'http://lithify.me/js/jquery.input_list.js'
	));?>
	<script type="text/javascript">
		<?=$this->scripts();?>
	</script>
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
</body>
</html>