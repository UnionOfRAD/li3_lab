<?php

echo $this->form->create($extension, array(
	'method' => 'post',
	'url' => array('plugin' => 'li3_lab', 'controller' => 'extensions', 'action' => 'edit')));

$this->form->config(array('templates' => array('checkbox' =>
	'<input type="hidden" name="{:name}" value="0" />
	 <input type="checkbox" value="1" name="{:name}"{:options} />'
)));

if (isset($extension->id) && isset($extension->rev)) : ?>
	<input type="hidden" name="id" value="<?=$extension->id;?>" />
	<input type="hidden" name="rev" value="<?=$extension->rev;?>" />
<?php endif;?>
<p>
	<?php
		echo $this->form->label('name', 'Extension Name', array(
			'class' => 'required'
		));
		echo $this->form->text('name');
		if (isset($extension->errors['name'])) {
			echo '<p style="color:red">'.$extension->errors['name'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('summary', 'Summary', array(
			'class' => 'required'
		));
		echo $this->form->textarea('summary', array('cols' => 40, 'rows' => 3));
		if (isset($extension->errors['summary'])) {
			echo '<p style="color:red">'.$extension->errors['summary'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('description', 'Description');
		echo $this->form->textarea('description', array('cols' => 40, 'rows' => 10));
		if (isset($extension->errors['description'])) {
			echo '<p style="color:red">'.$extension->errors['description'].'</p>';
		}
	?>
</p>
<p>
	<?php
		echo $this->form->label('code', 'Class code', array(
			'class' => 'required'
		));
		echo $this->form->textarea('code', array('cols' => 40, 'rows' => 15
		));
		if (isset($extension->errors['code'])) {
			echo '<p style="color:red">'.$extension->errors['code'].'</p>';
		}
	?>
</p>
<?php echo $this->form->submit('save', array('name' => 'verified'));?>
<?php echo $this->form->submit('cancel', array('name' => 'cancel'));?>
</form>
<p></p>