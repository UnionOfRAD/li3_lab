<h2>Add Extension</h2>

<?php $errors = $extension->errors(); ?>

<ul class="tabs">
	<li><a id="paste-json-tab" href="#paste-json">Paste JSON</a></li>
	<li><a id="upload-json-tab" href="#upload-json">Upload JSON</a></li>
	<li><a id="add-form-tab" href="#add-form">New Extension Form</a></li>
</ul>

<div id="paste-json" class="tab-page">
	<h3>Paste JSON</h3>
	<?php echo $this->form->create($extension, array('method' => 'POST','url' => $url)); ?>
		<div class="input">
		<?php
			echo $this->form->textarea('json', array('cols' => 40, 'rows' => 10));
			if (isset($errors['json'])) {
				echo '<div style="color:red">' . implode(', ', $errors['json']) . '</div>';
			}
		?>
		</div>
		<?php
			echo $this->form->submit('save');
			echo $this->form->submit('cancel', array('value' => 'cancel'));
		?>
	</form>
</div>

<div id="upload-json" class="tab-page">
	<h3>Upload JSON</h3>
	<form method="POST" enctype="multipart/form-data">
		<input type="file" name="formula">
		<?php
			echo $this->form->submit('upload');
			echo $this->form->submit('cancel', array('value' => 'cancel'));
		?>
	</form>
</div>

<div id="add-form" class="tab-page">
	<h3>New Extension Form</h3>
<?php 

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
	<button id="add-maintainer">add maintainer</button>
</div>
<div class="buttons">
<?php
	echo $this->form->submit('save');
	echo $this->form->submit('cancel', array('value' => 'cancel'));
?>
</div>
</form>

</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".tab-page").hide().addClass("hidden");
		$("ul.tabs li a").click(function() {
			var id = $(this).attr("id");
			var page = id.match(/(.*)\-tab/);
			page = "#"+page[1];
			if ($(page).hasClass("hidden")) {
				$(".tab-page").hide().addClass("hidden");
				$(page).show().removeClass("hidden");
			}
			return false;
		});
		$("#add-form").show().removeClass("hidden");
	});
</script>
