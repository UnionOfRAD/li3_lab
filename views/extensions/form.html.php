<?php
echo $this->form->create($extension, array(
	'method' => 'POST',
	'url' => $url
));

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
		echo $this->form->label('name', 'Extension Name', array(
			'class' => 'required'
		));
		echo $this->form->text('name');
		if (isset($extension->errors['name'])) {
			echo '<div style="color:red">'.$extension->errors['name'].'</div>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('summary', 'Summary', array(
			'class' => 'required'
		));
		echo $this->form->textarea('summary', array('cols' => 40, 'rows' => 3));
		if (isset($extension->errors['summary'])) {
			echo '<div style="color:red">'.$extension->errors['summary'].'</div>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('description', 'Description');
		echo $this->form->textarea('description', array('cols' => 40, 'rows' => 10));
		if (isset($extension->errors['description'])) {
			echo '<div style="color:red">'.$extension->errors['description'].'</div>';
		}
	?>
</div>
<div id="mm" class="input">
	<?php
		echo $this->form->label('maintainers', 'Maintainers');
		echo '<a href="#" class="add-maintainer" onclick="javascript:add(); return false;">Add</a>';
		echo $this->maintainer->render(0, $extension->maintainers[0]);
		$next = 1;
		if (isset($extension->maintainers) && sizeof($extension->maintainers->to("array")) > 1) {
			foreach ($extension->maintainers as $k => $main) {
				if ($k == 0) continue; // skip  the first;
				$next++;
				echo $this->maintainer->render($k, $extension->maintainers[$k]);
			}
		}
		echo "<script type='text/javascript'>
			var maintainer_count = $next;
			var maintainer_template = '{$this->maintainer->template()}';
		</script>";
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('code', 'Class code', array(
			'class' => 'required'
		));
		echo $this->form->textarea('code', array('cols' => 40, 'rows' => 15
		));
		if (isset($extension->errors['code'])) {
			echo '<div style="color:red">'.$extension->errors['code'].'</div>';
		}
	?>
</div>
<?php echo $this->form->submit('save', array('name' => 'verified'));?>
<?php echo $this->form->submit('cancel', array('name' => 'cancel'));?>
</form>
<?php

 //var_dump($extension->data());

?>