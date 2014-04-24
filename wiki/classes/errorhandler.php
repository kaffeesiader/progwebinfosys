<?php
/*
 * Handles all the user defined error messages and displays them in our view;
 */
class ErrorHandler {
	// an instance of our page object to be able to display messages
	private $page;
	
	public function __construct($page) {
		$this->page = $page;
	}
	
	/*
	 * Display error messages in the Message section of our view
	 * We only react to user defined messages here.
	 * 
	 */
	function errorHandler($errorCode, $errorMessage, $errorFile, $errorLine) {
		switch ($errorCode) {
			case E_USER_ERROR :
				// in case of an error we want to display the message and exit...
				$this->page->setError($errorMessage);
				// render the page and exit
				echo $this->page->render();
				exit;
				// other messages are just displayed at the appropriate location
			case E_USER_WARNING :
				$this->page->setWarning($errorMessage);
				return true;
			case E_USER_NOTICE :
				$this->page->setNotice($errorMessage);
				return true;
			default :
				// let the internal message handler deal with the problem...
				return false;
				break;
		}
	}
}


?>