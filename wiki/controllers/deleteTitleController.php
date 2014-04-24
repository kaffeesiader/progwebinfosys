<?php

class deleteTitleController extends Controller {

	private $title;

	public function __construct() {
		$this->title = !empty($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
	}

	protected function render($view) {
		
		if(!empty($this->title)) {
			Wiki::deleteArticle($this->title);
			$this->showMessage("Article '$this->title' successfully deleted!");
		}
		// redirect to wiki home
		$this->redirect('');
	}
}

?>
