<?php 
require_once("/var/www/html/functions.php");

unlink($_GET["filename"]);
header("Location: http://138.232.66.105/miniwiki.php");
?>
