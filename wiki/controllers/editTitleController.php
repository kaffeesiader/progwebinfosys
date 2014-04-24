<?php

class editTitleController extends Controller {

	private $title;

	public function __construct() {
		$this->title = !empty($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
	}

	protected function render($view) {
		
		if(isset($_POST['wiki_submit'])) {
			$title = htmlspecialchars($_POST['wiki_title']);
			$content = htmlspecialchars($_POST['wiki_content']);
			$imageAllign = htmlspecialchars($_POST['wiki_allign']);
			$imagePath = !empty($_FILES) ? $_FILES['wiki_image']['tmp_name'] : '';
				
			Wiki::saveArticle ($title, $content, $imagePath, $imageAllign);
			$this->showMessage("Article '$title' successfully saved.");
			// redirect to wiki view
			$this->redirect('title/'.$title);
		}
			
		$title = $this->title;
		$article = Wiki::getArticle($title);
		
		$view->setTemplate('editTitle');
		$view->assign('title', $article->getTitle());
		$view->assign('content', $article->getContent());
		$view->assign('allign', $article->getImageAllign());
	}
}

?>
