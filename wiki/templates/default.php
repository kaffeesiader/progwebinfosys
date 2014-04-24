<!DOCTYPE HTML>

<html lang="en">
	<head>
		<link href="/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<title>POWIS - MikiWiki</title>
	</head>

	<body id="wiki">
		<div id="wrapper">

			<div id="header">
				<h1>
					<a href="/wiki/index.php">
					<img id="logo" src="/images/logo.jpg" width="296" height="150">
					</a>
				</h1>
				
				<ul id="top_menu">
					<li><a href="/wiki/settings">Settings</a></li>
					<li><a href="/wiki/auth">Login</a></li>
					<li><a href="/wiki/unregister">Logout</a></li>
				</ul>
				
				<p><span>Smart Web Solutions</span> Project Website</p>

				<form id="searchForm" action="/wiki/index.php" method="get" onsubmit="return getElementById('searchInput').value.length > 0;">
					<div id="search">
						<input id="searchInput" type="search" name="query" title="Search the wiki" placeholder="Search..."/>
						<input type="hidden" name="action" value="searchTitle" />
						<input id="searchButton" type="submit" value="Find" />
					</div>
				</form>
			</div>

			<div id="main">
				<div id="navigation">
					<ul>
			        	<li><a href="/wiki/index.php?action=editUser">Add user</a></li>
			        	<li><a href="/wiki/index.php?action=addTitle">Add title</a></li>
					</ul>
					<ul>
						<li><a href="/wiki/index.php?action=generate&nArticles=100">+ 100</a></li>
						<li><a href="/wiki/index.php?action=generate&nArticles=1000">+ 1.000</a></li>
			        	<li><a>+ 10.000</a></li>
			        	<li><a>+ 100.000</a></li>
					</ul>
				</div>
				
				<div id="content">
					<? if(isset($this->_['profile'])): ?>
						<div class="wiki_message">
							<?= $this->_['profile'] ?>
						</div>
					<? endif;?>
					
					<? if(isset($this->_['error'])): ?>
						<div class="wiki_error">
							<?= $this->_['error'] ?>
						</div>
					<? endif;?>
					
					<? if(isset($this->_['message'])): ?>
						<div class="wiki_message">
							<?= $this->_['message'] ?>
						</div>
					<? endif;?>
					
					<? if(isset($this->_['warning'])): ?>
						<div class="wiki_warning">
							<?= $this->_['warning'] ?>
						</div>
					<? endif;?>
					
					<? if(isset($this->_['notice'])): ?>
						<div class="wiki_notice">
							<?= $this->_['notice'] ?>
						</div>
					<? endif;?>
					
						<div class="wiki_content">
							<?= $this->_['content'] ?>
						</div>
						
					<? if(isset($this->_['footer'])): ?>
						<div class="wiki_footer">
							<?= $this->_['footer'] ?>
						</div>
					<? endif; ?>
				</div> <!-- end content -->

			</div> <!-- end main -->
			
			<?php include_once("../footer.html"); ?>
		</div> <!-- end wrapper -->
	</body>
</html>
