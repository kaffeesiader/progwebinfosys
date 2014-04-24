<h1>Search results for '<?= $this->_['query'] ?>'</h1>
<p><b>Search returned <?= $this->_['count'] ?> results</b></p>

<ul>
<? foreach ($this->_['results'] as $title): ?>	
	<li>
		<a href="/wiki/title/<?= rawurlencode($title) ?>"><?= $title ?></a>
	</li>
<? endforeach; ?>
</ul>
<hr/>
<div id="pagination"><?php echo $this->_['pagination'] ?></div>