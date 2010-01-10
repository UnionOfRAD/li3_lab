<?php

$errors = $plugin->errors();
echo $this->form->create($plugin, array('url' => array('plugin' => 'li3_lab', 'action' => 'verify')));

$this->form->config(array('templates' => array('checkbox' =>
	'<input type="hidden" name="{:name}" value="0" />
	 <input type="checkbox" value="1" name="{:name}"{:options} />'
)));

if (isset($plugin->id) && isset($plugin->rev)) {
	echo $this->form->hidden('id');
	echo $this->form->hidden('rev');
}
?>
<div class="input">
	<?php
		echo $this->form->label('name', 'Plugin Name', array(
			'class' => 'required'
		));
		echo $this->form->text('name');
		if (isset($errors['name'])) {
			echo '<p style="color:red">' . implode(', ', $errors['name']) . '</p>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('version', 'Version', array(
			'class' => 'required'
		));
		echo $this->form->text('version');
		if (isset($errors['version'])) {
			echo '<p style="color:red">' . implode(', ', $errors['version']) . '</p>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('summary', 'Summary', array(
			'class' => 'required'
		));
		echo $this->form->textarea('summary', array('cols' => 40, 'rows' => 5));
		if (isset($errors['summary'])) {
			echo '<p style="color:red">' . implode(', ', $errors['summary']) . '</p>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('description', 'Description');
		echo $this->form->textarea('description', array('cols' => 40, 'rows' => 15));
		if (isset($errors['description'])) {
			echo '<p style="color:red">' . implode(', ', $errors['description']) . '</p>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('source', 'Source Path', array(
			'class' => 'required'
		));
		echo $this->form->text('source');
		if (isset($errors['source'])) {
			echo '<p style="color:red">' . implode(', ', $errors['source']) . '</p>';
		}
	?>
</div>
<div class="input">
	<fieldset id="maintainers">
		<legend>Maintainers</legend>
	<?php
		if (isset($errors['maintainers'])) {
			echo '<div style="color:red">' . implode(', ', $errors['maintainers']) . '</div>';
		}
		echo $this->maintainer->render($plugin->maintainers);
	?>
	</fieldset>
	<a href="#add-maintainer" id="add-maintainer">Add maintainer</a>
</div>
<?php echo $this->form->submit('save', array('name' => 'verified'));?>
<?php echo $this->form->submit('cancel', array('value' => 'cancel'));?>
</form>
<p></p>