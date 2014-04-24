<?php

class Paginator {
	
	private $links_per_site_limit;
	private $total_titles; // total number of titles in the database
	private $total_pages; // total number of pages
	private $title_offset; // offset of the title list, based on current page
	private $current_page; // page where our title is located
	
	function __construct() {
		// initialize paginator
		$this->links_per_site_limit = Settings::getItemsPerPage();
		$this->getTitleNumber();
		$this->getPageNumber();
		$this->getCurrentPage();
		$this->calculateListOffset();
	}

	// release some resources here
	function __destruct() {
		
	}

	public function getTitleOffset() {
		return $this->title_offset;
	}
	
	public function getResultCount() {
		return $this->total_titles;
	}

	// getTitleNumber returns number of rows in table pages
	private function getTitleNumber() {
		$db = db::getInstance();
		$query_str = isset($_GET['query']) ? $_GET['query'] : '';
		
		$this->total_titles = $db->getResultCount($query_str);
	}

	// getPageNumber returns number of pages
	private function getPageNumber() {
		$this->total_pages = ceil($this->total_titles / $this->links_per_site_limit);
	}

	// get current page or set default page (first page)
	private function getCurrentPage() {
		if(isset($_GET['wikipage']) && is_numeric($_GET['wikipage'])) {
			// insert sql query for title
			//$currentSite = $this->getSiteIndexByTitle($_GET['title']);
			//$currentPage = ceil($currentSite / $links_per_site_limit);
			$this->current_page = (int) $_GET['wikipage'];
			// check if current page is below limit or set to last page / first page
			if($this->current_page > $this->total_pages) {
				$this->current_page = $this->total_pages;
			}
			if($this->current_page < 1) {
				$this->current_page = 1;
			}
		} else {
			$this->current_page = 1;
		}
	}

	// returns offset of list based on current page
	private function calculateListOffset() {
		$this->title_offset = ($this->current_page - 1) * $this->links_per_site_limit;
	}

	private function createLink($page_id, $link_txt) {
		$query_str = isset($_GET['query']) ? $_GET['query'] : '';
		$params = !empty($query_str) ? "action=searchTitle&query=$query_str&" : '';
		$params .= "wikipage=$page_id";
		
		$link = "<a href=\"/wiki/index.php?$params\">$link_txt</a>";
		
		return $link;
	}
		
	// returns array of elements for Paginator.
	// Example first: 1 2 3 4 5 6 7 8 9 10 > >>
	// Example middle: << < 2 3 4 5 [6] 7 8 9 10 11 > >>
	// Example last: << < 95 96 97 98 99 100 101 102 103 104
	public function getHtml() {
		$html = " ";
		
		// if not on page 1, don't show back links
		if ($this->current_page > 1) {
			// show << link to go back to page 1
			$html .= $this->createLink ( 1, '<<' );
			// get previous page number
			$prevpage = $this->current_page - 1;
			// show previous link
			$html .= $this->createLink ( $prevpage, '<' );
		}
		// range of num links to show
		$range = 3;
		
		// loop to show links to range of pages around current page
		for($x = ($this->current_page - $range); $x < (($this->current_page + $range) + 1); $x ++) {
			// if it's a valid page number...
			if (($x > 0) && ($x <= $this->total_pages)) {
				// if we're on current page...
				if ($x == $this->current_page) {
					// 'highlight' it but don't make a link
					$html .= "[<b> $x </b>]";
					// if not current page...
				} else {
					// make it a link
					$html .= $this->createLink ( $x, $x );
				}
			}
		}
		
		// if not on last page, show forward and last page links
		if ($this->current_page != $this->total_pages) {
			// get next page
			$nextpage = $this->current_page + 1;
			// echo forward link for next page
			$html .= $this->createLink ( $nextpage, '>' );
			// echo forward link for lastpage
			$html .= $this->createLink ( $this->total_pages, '>>' );
		}
		
		return $html;
	}
	

	

}

?>
