<?php
/**
 * Represents a wiki article
 * 
 */
class Article {
	// some constants
	const NEW_ARTICLE = -1;
	
	private $id = Article::NEW_ARTICLE;
	private $creationDateTime;
	private $creator;
	private $editDateTime;
	private $editor;
	private $title;
	private $content;
	private $imageAllign;
	
	public function __construct($id, $title, $content = '', 
								$creationDateTime = '', $creator = '',
								$editDateTime = '', $editor = '', 
								$imageAllign = 'left') {
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->creationDateTime = $creationDateTime;
		$this->creator = $creator;
		$this->editDateTime = $editDateTime;
		$this->editor = $editor;
		$this->imageAllign = $imageAllign;
	}
	/*
	 * Get the content of this article parsed as HTML text
	 */
	public function getHTMLContent() {
		$html = $this->parseText($this->content);
		return $html;
	}
	
	/*
	 * Parse the raw content of this article into HTML text
	 */
	private function parseText($text) {
		// parse link elements
		$link_pattern = "/\[\[(.+?)\]\]/";

		// callback to compute each match
		// it is important to encode each link
		$callback = function ($title) {
						$urlEnc = rawurlencode($title[1]);
						return "<a href=\"/wiki/title/$urlEnc\">$title[1]</a>";
					};
		
		$text = preg_replace_callback($link_pattern, $callback, $text);
		
		// parse headlines
		// $h_pattern = "/---(.+)---[\n|\r|\r\n]/";
		$h_pattern = "/---(.+?)---/";
		$h_repl = "</p><h2>$1</h2><p>";
		$text = preg_replace($h_pattern, $h_repl, $text);
	
		$imgName = $this->getImageName();
		$imgAllign = 'title-img-'.$this->getImageAllign();
		$imgTag = "<img src=\"/wiki/images/$imgName\" class=\"$imgAllign\"/>";
		$text = "<p>".$imgTag.$text."</p>";
	
		return $text;
	}
	
	public function __toString() {
		return $this->getHTMLContent();
	}
	/*
	 * Return the names of all the titles the given content links to
	 */
	public static function getLinkedTitles($content) {
		preg_match_all("|\[\[(.+?)\]\]|", $content, $out);
		// remove duplicates
		$links = array_unique($out[1]);
	
		return $links;
	}
	/*
	 * Create a new article given a data row from the database
	 */
	public static function fromDataRow($row) {
	
		$id = isset($row['id']) ? $row['id'] : Article::NEW_ARTICLE;
		$creationDateTime = isset($row['creationDateTime']) ? $row['creationDateTime'] : '';
		$creator = isset($row['creator']) ? $row['creator'] : '';
		$editDateTime = isset($row['editDateTime']) ? $row['editDateTime'] : '';
		$editor = isset($row['editor']) ? $row['editor'] : '';
		$title = isset($row['title']) ? $row['title'] : '';
		$content = isset($row['content']) ? $row['content'] : '';
		$imageAllign = isset($row['imageAllign']) ? $row['imageAllign'] : 'left';
	
		$a = new Article($id, $title, $content, $creationDateTime, $creator, $editDateTime, $editor, $imageAllign);
	
		return $a;
	}
	/*
	 * Is this article new?
	 */
	public function isNew() {
		return $this->id == Article::NEW_ARTICLE;
	}
	/*
	 * Get the filename of this article's image.
	 * Returns the name of a default image if no image was uploaded
	 */
	public function getImageName() {
		$filename = $this->id.'.png';
		$path = IMAGE_SAVE_DIR.'/'.$filename;
		if(file_exists($path)) {
			return $filename;
		} else {
			return 'default.jpeg';
		}
	}
	
	/* ---------------- Getters and Setters ----------------------*/
	
	public function getId() {
		return $this->id;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function getEditDateTime() {
		return $this->editDateTime;
	}
	
	public function getEditor() {
		return $this->editor;
	}
	
	public function getCreationDateTime() {
		return $this->creationDateTime;
	}
	
	public function getCreator() {
		return $this->creator;
	}
	
	public function getImageAllign() {
		return $this->imageAllign;
	}
	
}

?>