<?php 

/*
 * Holds information about the current session's settings
 */
class Settings {
	
	public static function getItemsPerPage() {
		
		if(isset($_SESSION['items_per_page'])) {
			return $_SESSION['items_per_page'];
		} else {
			return 15;
		}
	}	
	
	public static function setItemsPerPage($value) {
		
		$_SESSION['items_per_page'] = $value;
	}
	
	public static function setOptimizationOn($value) {
		
		$_SESSION['optimization'] = $value;
		
	}
	
	public function getOptimizationOn() {
		if(isset($_SESSION['optimization'])) {
			return $_SESSION['optimization'];
		} else {
			return true;
		}
	}
	
	public function setShowProfileInformation($value) {
	
		$_SESSION['profile'] = $value;
	}
	
	public function getShowProfileInformation() {
		
		if(isset($_SESSION['profile'])) {
			return $_SESSION['profile'];
		} else {
			return true;
		}
	}
}

?>