<h2><?=$this->title('Add Plugin');?></h2>

<?php $errors = $plugin->errors(); ?>

<ul class="tabs">
	<li><a id="paste-json-tab" href="#paste-json">Paste Formula</a></li>
	<li><a id="upload-json-tab" href="#upload-json">Upload Formula</a></li>
	<li><a id="add-form-tab" href="#add-form">New Plugin Form</a></li>
</ul>

<div id="paste-json" class="tab-page">
	<h3>Paste JSON</h3>
	<?php echo $this->form->create($plugin, array('method' => 'POST', 'url' => $url)); ?>
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
	<?php echo $this->form->create($plugin, array(
		'method' => 'POST', 'url' => $url, 'enctype' => 'multipart/form-data'
	));?>
		<input type="file" name="formula">
		<?php
			echo $this->form->submit('upload');
			echo $this->form->submit('cancel', array('value' => 'cancel'));
		?>
	</form>
</div>

<div id="add-form" class="tab-page">
<h3>New Plugin Form</h3>
<?php echo $this->form->create($plugin, array('method' => 'POST', 'url' => $url));?>

<div class="input">
	<?php
		echo $this->form->label('name', 'Plugin Name', array('class' => 'required'));
		echo $this->form->text('name');
		if (isset($errors['name'])) {
			echo '<p style="color:red">' . implode(', ', $errors['name']) . '</p>';
		}
	?>
</div>
<div class="input">
	<?php
		echo $this->form->label('version', 'Version', array('class' => 'required'));
		echo $this->form->text('version');
		if (isset($errors['version'])) {
			echo '<p style="color:red">' . implode(', ', $errors['version']) . '</p>';
		}
	?>
</div>
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
		if (isset($errors['sources'])) {
			echo '<div style="color:red">' . implode(', ', $errors['sources']) . '</div>';
		}
		echo $this->form->multi('sources');
	?>
</div>
<div class="input">
	<fieldset id="maintainers">
		<legend>Maintainers</legend>
	<?php
		if (isset($errors['maintainers'])) {
			echo '<div style="color:red">' . implode(', ', $errors['maintainers']) . '</div>';
		}
		echo $this->form->multi('maintainers', array('name', 'email', 'website'));
	?>
	</fieldset>
</div>
<div class="buttons">
<?php
	echo $this->form->submit('save');
	echo $this->form->submit('cancel', array('value' => 'cancel'));
?>
</div>
</form>

</div>
<?php
$this->scripts(
<<<'script'
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
		$("#paste-json").show().removeClass("hidden");
		$(".sources").input_list();
		$(".maintainers").input_list();
	});
script
);
?>