<h1><?= $this->_['title'] ?></h1>
<div class="title-content">
	<?= $this->_['content']?>
	<div class="clear"></div>
</div>
<div id="page_references">
	<h3>Referencing titles</h3>
	<? if(!empty($this->_['references'])): ?>
		<ul>
		<? foreach ($this->_['references'] as $title): ?>
			<li><a href="/wiki/title/<?= rawurlencode($title) ?>"><?= $title ?></a></li>
		<? endforeach; ?>
		</ul>
	<? else : ?>
		<em>This title is currently not referenced by any other page!</em>
	<? endif; ?>
</div>
<hr/>
<div class="title_meta">
	This title was created on <?= $this->_['created'] ?> by user '<?= $this->_['creator'] ?>'<br/>
	and edited on <?= $this->_['edited'] ?> by user '<?= $this->_['editor'] ?>'.
</div>
<hr/>
<div class="title_options">
	<ul>
		<li><a href="/wiki/title/<?= $this->_['title'] ?>/delete">Delete this page</a></li>
		<li><a href="/wiki/title/<?= $this->_['title'] ?>/edit">Edit</a></li>
	</ul>
</div>
