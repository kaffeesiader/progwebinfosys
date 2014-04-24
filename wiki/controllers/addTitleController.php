<?php

class addTitleController extends Controller {

	protected function render($view) {
		
		if(isset($_POST['wiki_submit'])) {
			$title = htmlspecialchars($_POST['wiki_title']);
			$content = htmlspecialchars($_POST['wiki_content']);
			$imageAllign = htmlspecialchars($_POST['wiki_allign']);
			$imagePath = !empty($_FILES) ? $_FILES['wiki_image']['tmp_name'] : '';
				
			Wiki::saveArticle ($title, $content, $imagePath, $imageAllign);
			$this->showMessage("Article '$title' successfully created.");
			// redirect to wiki view
			$this->redirect('title/'.$title);
		}
			
		$view->setTemplate('addTitle');
	}
}

?>
