<?php

class searchTitleController extends Controller {

	public function authenticationRequired() {
		return false;
	}
	
	protected function render($view) {
		
		if(isset($_GET['query'])) {
			// show query results
			$query = htmlspecialchars($_GET['query']);
			
			$limit = Settings::getItemsPerPage();
			$paginator = new Paginator();
			$start_index = $paginator->getTitleOffset();
			$count = $paginator->getResultCount();
			$results = Wiki::findTitles($query, $start_index, $limit);
				
			$view->setTemplate('searchResults');
			$view->assign('query', $query);
			$view->assign('count', $count);
			$view->assign('results', $results);
			$view->assign('pagination', $paginator->getHtml());
			
		} else {
			// redirect to home if no query string provided
			$this->redirect('');
		}	
		
	}
}

?>
