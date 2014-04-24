<?php

class defaultController extends Controller {

	private $title;

	public function __construct() {
		$this->title = !empty($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
	}
	
	public function authenticationRequired() {
		false;
	}

	protected function render($view) {
		$title = $this->title;

		if (!empty($title)) {
			$article = Wiki::getArticle($title);
				
			if($article->isNew()) {
				// redirect to edit page because title does not exist
				$this->redirect('title/'.rawurlencode($title).'/edit');
			} else {
				// get all articles that reference the current title
				$refs = Wiki::getReferencingTitles($article->getTitle());
				$refs = array_map("htmlspecialchars", $refs);
		
				$view->setTemplate('showTitle');
				$view->assign('title', $article->getTitle());
				$view->assign('content', $article->getHTMLContent());
				$view->assign('created', $article->getCreationDateTime());
				$view->assign('creator', $article->getCreator());
				$view->assign('edited', $article->getEditDateTime());
				$view->assign('editor', $article->getEditor());
		
				$view->assign('references', $refs);
			}
		
		} else {
			$view->setTemplate ('showList');
			$limit = Settings::getItemsPerPage();
			$paginator = new Paginator();
			$start_index = $paginator->getTitleOffset();
			$results = Wiki::findTitles('', $start_index, $limit);
	
			$view->assign('titles', $results);
			$view->assign('pagination', $paginator->getHtml());
		}	
	}
}
