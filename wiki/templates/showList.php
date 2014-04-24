<h1>Miniwiki</h1>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
<p>
	<a href="?action=addTitle">Create a new Wiki page</a>
</p>

<ul>
<? foreach ($this->_['titles'] as $title): ?>	
	<li>
		<a href="/wiki/title/<?= rawurlencode($title) ?>"><?= $title ?></a>
	</li>
<? endforeach; ?>
</ul>
<hr/>
<div id="pagination"><?php echo $this->_['pagination'] ?></div>