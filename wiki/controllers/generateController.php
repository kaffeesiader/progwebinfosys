<?php

class generateController extends Controller {

	private $db;

	public function __construct() {
		$this->db = db::getInstance();
	}

	function __destruct() {
	}

	// function generates n Words randomly and returns them as string
	public function generateRandomContent($nWords) {
		$text = str_shuffle(str_repeat(str_shuffle('abcdefghijklmnopqrstuvwxyz   '), $nWords));
		return $text;
	}

	public function generateRandomTitle() {
		$title = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,1);
		$title .= str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ');
		return $title;
	}

	private function generateNArticles($nArticles) {
		$titles = array();
		$contents = array();
		for($i = 0; $i < $nArticles; $i++) {
			array_push($titles, $this->generateRandomTitle());
			array_push($contents, $this->generateRandomContent(1));
		}
		try {
			$this->db->generateMultipleTitles($titles, $contents, $nArticles);
		} catch(PDOException $ex) {
			trigger_error("Error in generateNArticles in generateController". $ex, E_USER_ERROR);
		}
	}

	public function render($view) {
		$nArticles = isset($_GET['nArticles']) && is_numeric($_GET['nArticles'])? $_GET['nArticles'] : 1;
		$this->generateNArticles($nArticles);
		$this->showMessage("$nArticles Articles generated");
		$this->redirect('index.php');
	}
}

?>
