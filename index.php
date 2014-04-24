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

<!DOCTYPE HTML>

<html lang="en">
	<head>
		<title><?php echo $website_title; ?> - Home</title>
		<link href="./css/layout.css" rel="stylesheet" type="text/css" media="screen" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	</head>

	<body id="home">
		<div id="wrapper">

			<?php include_once("header.html"); ?>

			<div id="main">
				<?php include_once("navigation.html"); ?>

				<div id="content">
					<h1>Home</h1>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p>
					<p>Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>
				</div> <!-- end content -->

			</div> <!-- end main -->
			
			<?php include_once("footer.html"); ?>
		</div> <!-- end wrapper -->
	</body>
</html>
