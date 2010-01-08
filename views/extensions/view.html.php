<?php
	$version = 1;
	if (isset($extension->_revisions)) {
		$version = $extension->_revisions->start;
	}

?>

<div id="extension">
	<h2><?=$extension->name;?></h2>
	<h3>Version: <?php echo $version;?> Created: <?=$extension->created;?></h3>
	<p class="summary"><?=$extension->summary;?></p>
	<div class="description"><?=$extension->description;?></div>
	<div class="actions" style="margin-bottom: 5px;">
		<a href="#">Download</a>
		 | <?php
		$rev_list = array(0 => 'View Old Revision');
		foreach ($extension->_revisions->ids as $k => $id) {
			$i = $extension->_revisions->start - $k;
			$rev_list[$i . '-' . $id] = $i . '-' . $id;
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
	<div class="code"><pre><code><?=$extension->code; ?></code></pre></div>
</div>