<form method="POST">

<?php
$this->form->config(array('templates' => array('checkbox' =>
	'<input type="hidden" name="{:name}" value="0" />
	 <input type="checkbox" value="1" name="{:name}"{:options} />'
)));

if (isset($plugin->id) && isset($plugin->rev)) : ?>
	<input type="hidden" name="id" value="<?=$plugin->id;?>" />
	<input type="hidden" name="rev" value="<?=$plugin->rev;?>" />
<?php endif;?>

<p>
<?php
	echo $this->form->label('maintainer', 'Who are you?', array(
		'class' => 'required'
	));
	echo $this->form->text('maintainer', array(
		'value' => $plugin->maintainer
	));
	if (isset($plugin->errors['maintainer'])) {
		echo '<p style="color:red">'.$plugin->errors['maintainer'].'</p>';
	}
?>
<p>
<?php echo $this->form->submit('save');?>
</form>