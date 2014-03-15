<?php require_once("config.php"); ?>
<?php require_once("functions.php"); ?>

<?php 
if(isset($_POST['pwd'])) {
	$pass = $_POST['pwd'];
	if($pass == $website_password) {
		if(isset($_POST['title'])) {
			$title = $_POST['title'];
			$article = $_POST['article'];
			if(!empty($title) && !empty($article)) {
				if(!file_exists("articles/" . str2filename($title, ".html"))) {
					$ref = createWikiArticle($title, $article);
				} else {
					echo "<strong>This article already exists!</strong>";
				}
			} else {
				echo "<strong>Missing title or article text!</strong>\n";
			}
		}
	} else {
		echo "<strong>Wrong password!</strong>\n";
	}
}
?>

<!DOCTYPE HTML>

<html lang="en">
        <head>
                <title><?php echo $website_title; ?> - MiniWiki</title>
                <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen" />
        </head>

        <body id="miniwiki">
                <div id="wrapper">

                        <?php include_once("header.html"); ?>

                        <div id="main">
                                <?php include_once("navigation.html"); ?>

                                <div id="content">
                                        <h1>Mini Wiki</h1>
					<form action="miniwiki.php" method="POST">
                                                <p>Create a new article:</p>
                                                Title:<br>
                                                <input type="text" name="title"><br>
                                                Article:<br>
                                                <input type="text" name="article"><br>
						Password:<br>
						<input type="password" name="pwd"><br><br>
                                                <input type="submit" name="submit"><br><br>
                                        </form>
					<p>Already created articles:</p>
					<?php
					$fnames = glob("articles/*.html");
					echo "<ul type=\"none\">";
					foreach($fnames as $fname) {
						$fname = str_replace("articles/", "", $fname);
						$fname = str_replace(".html", "", $fname);
						$fname = str_replace("_", " ", $fname);
						echo "<li><a href=\"articles/" . str2filename($fname, ".html") . "\">$fname</a></li>";
					}
					echo "</ul>";
					?>
                                </div> <!-- end content -->

                        </div> <!-- end main -->

                        <?php include_once("footer.html"); ?>
                </div> <!-- end wrapper -->
        </body>
<html>

