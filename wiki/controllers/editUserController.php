<?php

class editUserController extends Controller {

	protected function render($view) {
		
		$username = '';
		$email = '';
		
		if(isset($_POST['user_submit'])) {
			$username = htmlspecialchars($_POST['user_name']);
			$email = htmlspecialchars($_POST['user_email']);
			$password = $_POST['user_password'];
			
			if(Wiki::createUser($username, $email, $password)) {
				$this->showMessage("User '$username' successfully created");
				// redirect to wiki home
				$this->redirect('');
			} 
		}
	
		$view->setTemplate("editUser");
		$view->assign('email', $username);
		$view->assign('username', $email);
		
	}
}

?>
