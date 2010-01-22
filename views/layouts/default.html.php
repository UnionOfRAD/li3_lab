<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<?php
$assetHost = $this->request()->env('HTTP_HOST');
$assetBase = "http://{$assetHost}";
$commandBase = "http://{$assetHost}/cmd";
?>
<!doctype html>
<html>
<head>
	<?=$this->html->charset(); ?>
	<title>Lithium Laboratory</title>
	<?=$this->html->link('Icon', null, array('type' => 'icon')); ?>

	<?=$this->html->style(array(
		"{$assetBase}/css/base.css",
		"{$assetBase}/css/u1m.css",
		"{$assetBase}/css/li3_lab.css",
		"{$assetBase}/css/rad.cli.css"
	)); ?>
	<?=$this->html->script(array(
		'http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js',
		"{$assetBase}/js/jquery.input_list.js",
		"{$assetBase}/js/rad.cli.js"
	));?>
	<?=$this->scripts(); ?>
</head>
<body>
	<div id="wrapper">
		<div id="container" class="<?php echo (!empty($home))? 'home' : 'internal' ; ?>">
			<div id="header">
				<h1><?php echo $this->html->link('Lithium Laboratory', array(
					'library' => 'li3_lab',
					'controller' => 'home',
					'action' => 'index'
				)); ?></h1>
				<div class="nav capsule">
					<ul>
						<li class="add-plugin">
							<?php echo $this->html->link('Add Plugin', array(
								'library' => 'li3_lab', 'Plugins::add'
							)); ?>
						</li>
						<li class="add-extension">
							<?php echo $this->html->link('Add Extension', array(
								'library' => 'li3_lab', 'Extensions::add'
							)); ?>
						</li>
						<li class="all-plugins">
							<?php echo $this->html->link('View Plugins', array(
								'library' => 'li3_lab', 'Plugins::index'
							)); ?>
						</li>
						<li class="all-extensions">
							<?php echo $this->html->link('View Extensions', array(
								'library' => 'li3_lab', 'Extensions::index'
							)); ?>
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

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function () {
			RadCli.setup({
				assetBase: '<?php echo $assetBase; ?>',
				commandBase: '<?php echo $commandBase; ?>'
			});
		});
	</script>
</body>
</html>