<?php
$errors = $extension->errors();
echo $this->form->create($extension, array('method' => 'POST','url' => $url));

$this->form->config(array('templates' => array('checkbox' =>
	'<input type="hidden" name="{:name}" value="0" />
	 <input type="checkbox" value="1" name="{:name}"{:options} />'
)));

if (isset($extension->id) && isset($extension->rev)) {
	echo $this->form->hidden('id');
	echo $this->form->hidden('rev');
}
?>
<div class="input">
	<?php
		echo $this->form->label('summary', 'Summary', array('class' => 'required'));
		echo $this->form->text('summary');
		if (isset($errors['summary'])) {
			echo '<div style="color:red">' . implode(', ', $errors['summary']) . '</div>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('description', 'Description');
		echo $this->form->textarea('description', array('cols' => 40, 'rows' => 10));
		if (isset($errors['description'])) {
			echo '<div style="color:red">' . implode(', ', $errors['description']) . '</div>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('code', 'Code', array('class' => 'required'));
		echo $this->form->textarea('code', array('cols' => 40, 'rows' => 15));
		if (isset($errors['code'])) {
			echo '<div style="color:red">' . implode(', ', $errors['code']) . '</div>';
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
		echo $this->maintainer->render($extension->maintainers);
	?>
	</fieldset>
	<a href="#add-maintainer" id="add-maintainer">Add maintainer</a>
</div>
<div class="buttons">
<?php
	echo $this->form->submit('save');
	echo $this->form->submit('cancel', array('value' => 'cancel'));
?>
</div>
</form>