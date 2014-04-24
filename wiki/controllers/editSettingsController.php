<?php

class editSettingsController extends Controller {

	public function authenticationRequired() {
		false;
	}

	protected function render($view) {
		// check if submit button was clicked...
		if(isset($_POST['settings_submit'])) {
			// extract parameters from request...
			$ipp = $_POST['settings_items_per_page'];
			$optimized = isset($_POST['settings_optimized']) ? true : false;
			$profile = isset($_POST['settings_profile']) ? true : false;
			// ... and update the settings
			Settings::setItemsPerPage($ipp);
			Settings::setOptimizationOn($optimized);
			Settings::setShowProfileInformation($profile);
			// show a status message and redirect to wiki home
			$this->showMessage('Settings updated');
			$this->redirect('');
		}
		
		$view->setTemplate('settings');
		$view->assign('items_per_page', Settings::getItemsPerPage());
		$view->assign('optimized', Settings::getOptimizationOn());
		$view->assign('profile', Settings::getShowProfileInformation());
	}
}

?>
