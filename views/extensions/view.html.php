<?php
	$version = 1;
	if (isset($extension->_revisions)) {
		$version = $extension->_revisions->start;
	}
?>

<div id="extension">
	<div class="details">
		<h2><?=$extension->namespace . ' \\ ' . $extension->class;?></h2>
		<h3 class="summary"><?=$extension->summary;?></h3>
		<div class="actions">
			<a href="#">Download</a>
			 | <?php
			$rev_list = array(0 => 'View Old Revision');
			foreach ($extension->_revisions->ids as $k => $id) {
				$i = $extension->_revisions->start - $k;
				$rev_list[$i . '-' . $id] = $i . '-' . substr($id, 0, 6) . '...';
			}
			echo $this->form->create(null, array(
				'url' => array(
					'plugin' => 'li3_lab',
					'controller' => 'extensions',
					'action' => 'view',
					'args' => array($extension->id)
				),
				'id' => 'revision-form',
				'style' => 'margin:0; padding:0; display: inline;'
			));
			echo $this->form->select('revision', $rev_list, array(
				'id' => 'revision-select',
				'style' => 'margin:0; padding:0; display: inline;'
			));
			echo $this->form->submit('Get', array('style' => 'display:inline; margin:0 0 0 5px; padding: 1px;'));
			echo '</form>';
			?>
			 | <?=$this->Html->link('Newest', array(
					'plugin' => 'li3_lab',
					'controller' => 'extensions',
					'action' => 'view',
					'args' => array($extension->id)
			 ));?>
			 | <?=$this->Html->link('Edit', array(
					'plugin' => 'li3_lab',
					'controller' => 'extensions',
					'action' => 'edit',
					'args' => array($extension->id)
			 ));?>
		</div>
		<div class="php"><pre><code><?=$extension->code; ?></code></pre></div>
	</div>
	<div class="meta">
		<h4>Description</h4>
		<div class="description"><?=$extension->description;?></div>
		<h4>Details</h4>
		<ul>
			<li>Version: <?php echo (isset($extension->_revisions->start)) ?: 1;?></li>
			<li>Created: <?=$extension->created;?></li>
			<li>File: <?=$extension->file;?></li>
		</ul>
	<?php if (isset($extension->maintainers)) {?>
		<h4>Maintainers</h4>
		<ul class="maintainers">
		<?php
			foreach ($extension->maintainers as $man) {
				$name = (!empty($man->name)) ? $man->name : $man->email;
				if (empty($name)) continue;
				echo '<li><strong>';
				echo $name . '</strong> (<a href="mailto:' . $man->email . '">' . $man->email . '</a>) '
				 . '<a href="http://' . $man->website . '">' . $man->website . '</a>';
				echo '</li>';
			}
		?>
		</ul>
	<?php } else {
		echo '<p>No maintainers set.</p>';
	}?>
	</div>
</div>