<?php

/*
 * enable the automatic loading of our controller classes
 */
function __autoload($className) {
		require_once 'controllers/'.$className.'.php';
}

/*
 * Abstract base class for all our controllers
 * Provides a few functions that are common to all controllers.
 * 
 */
abstract class Controller {
	
	private $view;
	/*
	 * Provide access to this controllers view
	 */
	protected function getView() {
		if(!isset($this->view)) {
			$this->view = new View();
		}
		return $this->view;
	}
	/*
	 * Creates a controller that can deal with given action type
	 */
	public static function forAction($action) {
		
		if(empty($action)) {
			trigger_error("Unable to load controller - unknown action '$action'", E_USER_ERROR);
		} else {
			// create a controller instance based on the action name
			$controllerName = $action.'Controller';
			$controller = new $controllerName();
			return $controller;
		}
	}
	/*
	 * Child classes have to implement this function.
	 * Populates the view and displays the output
	 */
	protected abstract function render($view);
	/*
	 * Call the render function in child classes and generate the output
	 */
	public function display() {
		// check first if authentication is required and redirect if necessary
		if($this->authenticationRequired()) {
			$this->ensureAuthentication();
		}
		// look if there is a message to display
		if(isset($_SESSION['controller_message'])) {
			$msg = $_SESSION['controller_message'];
			// send message to our message handler
			trigger_error($msg, E_USER_NOTICE);
			// make sure the message only gets displayed once...
			unset($_SESSION['controller_message']);
		}
		
		$view = $this->getView();
		$this->render( $view);
		return $this->view->loadTemplate();
	}
	/*
	 * Ensures that a user is authenticated.
	 * If not, it redirects immediately to our login page.
	 */
	public function ensureAuthentication() {
		if(!$this->authenticated()) {
			$this->redirect('auth'.$_SERVER['REQUEST_URI']);
			exit;
		}
	}
	/*
	 * Is the current user allready authenticated?
	 */
	public function authenticated() {
		return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
	}
	/*
	 * If authentication is required the controller will redirect immediately to the
	 * login page. Authentication is required by default. If a controller requires no
	 * authentication it can override the default behaviour.
	 */
	public function authenticationRequired() {
		return true;
	}
	/*
	 * Redirect to given path
	 */
	public function redirect($path) {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/wiki'.(!empty($path) ? '/' : '').$path);
		exit;
	}
	/*
	 * Display a message as notice.
	 */
	public function showMessage($msg) {
		// store the message in the session in case of a redirection
		$_SESSION['controller_message'] = $msg;
	}

}

?>