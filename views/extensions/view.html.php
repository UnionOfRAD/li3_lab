<div id="extension">
	<h2><?=$extension->name;?></h2>
	<h3>Version: <?=$extension->version;?></h3>
	<p class="summary"><?=$extension->summary;?></p>
	<div class="description"><?=$extension->description;?></div>
	<div class="actions"><a href="#">Download code</a></div>
	<div class="code"><pre><code><?=$extension->code; ?></code></pre></div>
</div>