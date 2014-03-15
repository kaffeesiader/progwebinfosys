<?php require_once("config.php");?>

<?php
if(isset($_GET["titel"])) {
	$title = $_GET["titel"];
	if(file_exists("/var/www/html/articles/$title.html")) {
		header("Location: http://138.232.66.105/articles/$title.html");
	} else {
		header("Location: http://138.232.66.105/default.html");
	}
}
?>

<?php 
session_start();
if(!isset($_SESSION["start"])) {
	$_SESSION["start"] = date('l jS \of F Y h:i:s A');
}
echo "Your first vist on this site was on <strong>" . $_SESSION["start"] . "</strong>.";
?>

<!DOCTYPE HTML>

<html lang="en">
	<head>
		<title><?php echo $website_title; ?> - Home</title>
		<link href="css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	</head>

	<body id="home">
		<div id="wrapper">

			<?php include_once("header.html"); ?>

			<div id="main">
				<?php include_once("navigation.html"); ?>

				<div id="content">
					<h1>Home</h1>
					<p>In this content box we provide latest news about our projects.</p>
				</div> <!-- end content -->

			</div> <!-- end main -->
			
			<?php include_once("footer.html"); ?>
		</div> <!-- end wrapper -->
	</body>
<html>
