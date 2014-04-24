<?php

require_once 'classes/wiki.php';
require_once 'classes/article.php';
require_once 'classes/controller.php';
require_once 'classes/view.php';
require_once 'classes/page.php';
require_once 'classes/settings.php';
require_once 'classes/db.php';
require_once 'classes/errorhandler.php';
require_once 'classes/paginator.php';

define('IMAGE_SAVE_DIR', dirname(__FILE__).'/images');

session_start();
// uncomment to create test user
// Wiki::createUser('admin', 'admin@test.com', 'admin');

// create a new page
$page = new Page();
// use custom error handling functionality
$errorhandler = new ErrorHandler($page);
// redirect error handling to our error handler
set_error_handler(array($errorhandler, 'errorHandler'));

// trigger_error("Dies ist ein test", E_USER_NOTICE); // to test custom error handling functionality

// retrieve current action type
$action = isset($_GET['action']) ? $_GET['action'] : 'default';
// Controller erstellen
$controller = Controller::forAction($action);

// take start time for profiling information
$start_time = microtime(true);

$page->setContent($controller->display());

// display profiling information if necessary
$show_profile_info = Settings::getShowProfileInformation();

if($show_profile_info) {
	// take end time and calculate duration
	$end_time = microtime(true);
	$duration = $end_time - $start_time;
	$profile_msg = 'Rendering phase took '.$duration.' seconds';
	$page->setProfileMessage($profile_msg);
}

echo $page->render();


?>
