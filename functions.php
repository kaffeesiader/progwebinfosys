<?php 

function getPage($path) {
        if(file_exists($path)) {
                return openPage($path);
        } else {
                return openPage("/var/www/html/default.html");
        }
}

function getArticle($path) {
	if(file_exists($path)) {
		return openPage($path);
	} else {
		return openPage("/var/www/html/default.html");
	}
}

function openPage($pageurl) {
	$fh = fopen($pageurl, "r");
	$fc = fread($fh, filesize($pageurl));
	fclose($fh);
	return $fc;
}

function str2filename($str, $fileEnding) {
        $s = trim($str);
        $s = str_replace(" ", "_", $s);
	$s .= $fileEnding;
        return $s;
}

function createWikiArticle($articleTitle, $articleText) {
	$filename = str2filename($articleTitle, ".html");
	$path = "/var/www/html/articles/$filename";
	if(!file_exists($path)) {
		$fhandle = fopen("$path", "w");
		$str = "<h1>---" . $articleTitle . "---</h1>";
		$str .= "<p>" . $articleText . "</p>";
		$str .= "<a href=\"unlink.php?filename=$filename\">Artikel löschen</a>";
		fwrite($fhandle, $str);
		fclose($fhandle);
	}
	return $path;
}

?>


