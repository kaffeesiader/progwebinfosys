<?php

require_once 'classes/wiki.php';
require_once 'classes/view.php';
require_once 'classes/page.php';
require_once 'classes/db.php';
require_once 'classes/errorhandler.php';
require_once 'classes/settings.php';

session_start();

// create a new page
$page = new Page();
// use custom error handling functionality
$errorhandler = new ErrorHandler($page);
// redirect error handling to our error handler
set_error_handler(array($errorhandler, 'errorHandler'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$username = $_POST['username'];
	$password = $_POST['password'];

	// Benutzername und Passwort werden überprüft
	$db = db::getInstance();
	$user = $db->getUser($username);

	if($user) {
		$authenticated = crypt($password, $user->password) === $user->password;

		if($authenticated) {
			$_SESSION['authenticated'] = true;
			$_SESSION['user_id'] = $user->id;
			$_SESSION['username'] = $user->username;


			$hostname = $_SERVER['HTTP_HOST'];
			
			$redirectpath = isset($_GET['redirect']) ? $_GET['redirect'] : '/wiki';
			header('Location: http://'.$_SERVER['HTTP_HOST'].$redirectpath);
			exit;
			
		} else {
			trigger_error("Login failed! Invalid password!", E_USER_WARNING);
		}
	} else {
		trigger_error("Login failed! Unknown user '$username'", E_USER_WARNING);
	}
}

$loginView = new View();
$loginView->setTemplate('login');

$page->setContent($loginView->loadTemplate());

echo $page->render();

?>
