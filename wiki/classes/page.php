<?php
/**
 * Represents a whole page, containing the HTML header and body.
 * Offers a content property where the output of the controllers gets displayed
 * and various areas to display errors, warnings an messages.
 *
 */
class Page {
	
	private $view;
	
	function __construct() {
		$view = new View();
		$view->setTemplate("default");
		$view->assign('content', 'This page is currently empty');
		$this->view = $view;
	}
	/*
	 * Place the output of our controllers into page content area
	 */
	public function setContent($content) {
		$this->view->assign('content', $content);
	}
	/*
	 * Display an error message
	 */
	public function setError($error) {
		$this->view->assign('error', $error);
	}
	
	public function setMessage($message) {
		$this->view->assign('message', $message);
	}
	
	public function setWarning($message) {
		$this->view->assign('warning', $message);
	}
	
	public function setNotice($message) {
		$this->view->assign('notice', $message);
	}
	
	public function setProfileMessage($message) {
		$this->view->assign('profile', $message);
	}
	/*
	 * Create the HTML output
	 */
	public function render() {
		return $this->view->loadTemplate();
	}
	
}

?>