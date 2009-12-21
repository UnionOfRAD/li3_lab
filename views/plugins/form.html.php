<?php

echo $this->form->create(null, array('url' => array('plugin' => 'li3_lab', 'action' => 'verify')));

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
		echo $this->form->label('name', 'Plugin Name', array(
			'class' => 'required'
		));
		echo $this->form->text('name', array(
			'value' => $plugin->name
		));
		if (isset($plugin->errors['name'])) {
			echo '<p style="color:red">'.$plugin->errors['name'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('version', 'Version', array(
			'class' => 'required'
		));
		echo $this->form->text('version', array(
			'value' => $plugin->version
		));
		if (isset($plugin->errors['version'])) {
			echo '<p style="color:red">'.$plugin->errors['version'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('summary', 'Summary', array(
			'class' => 'required'
		));
		echo $this->form->textarea('summary', array(
			'value' => $plugin->summary, 'cols' => 40, 'rows' => 5
		));
		if (isset($plugin->errors['summary'])) {
			echo '<p style="color:red">'.$plugin->errors['summary'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('description', 'Description');
		echo $this->form->textarea('description', array(
			'value' => $plugin->description, 'cols' => 40, 'rows' => 15
		));
		if (isset($plugin->errors['description'])) {
			echo '<p style="color:red">'.$plugin->errors['description'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('source', 'Source Path', array(
			'class' => 'required'
		));
		echo $this->form->text('source', array(
			'value' => $plugin->source
		));
		if (isset($plugin->errors['source'])) {
			echo '<p style="color:red">'.$plugin->errors['source'].'</p>';
		}
	?>
</p>
<?php echo $this->form->submit('save', array('name' => 'verified'));?>
<?php echo $this->form->submit('cancel', array('name' => 'cancel'));?>
</form>
<p></p>