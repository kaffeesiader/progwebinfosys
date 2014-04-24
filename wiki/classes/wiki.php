<?php

/**
 * The facade class for our wiki
 *
 */
class Wiki {
	/*
	 * Retrieve the amount of titles matching the given query string
	 */
	public static function getResultCount($query) {
		$db = db::getInstance();
		$count = $db->getResultCount($query);
		
		return $count;
	}
	/*
	 * Get the titles, matching the given query string.
	 * Begin at $startIndex and return a maximum of $limit records
	 */
	public static function findTitles($query, $startIndex, $limit) {
		$db = db::getInstance();
		$titles = array();
		$titles = $db->findTitles($query, $startIndex, $limit);
		
		return $titles;
	}
	/*
	 * Get the article with given title
	 * Returns a new article if it does not exists yet
	 */
	public static function getArticle($title) {
		$db = db::getInstance();
		if(!($row = $db->getTitle($title))) {
			return new article(Article::NEW_ARTICLE, $title);
		} else {
			$article = Article::fromDataRow($row);
			return $article;
		}
	}
	/*
	 * Get all the titles that contain a reference to article with given title
	 */
	public static function getReferencingTitles($title) {
		$db = db::getInstance();
		return $db->getReferencingTitles($title);
	}
	/*
	 * Save given article data
	 */
	public static function saveArticle($title, $content, $imagePath, $imageAllign) {
		$db = db::getInstance();
		$user_id = $_SESSION['user_id'];
		
		try {
			if(empty($content)) {
				trigger_error('No content provided - article not saved', E_USER_WARNING);
				return false;
			} else {
				// store the new page in the database and retrieve its page_id
				$page_id = $db->saveTitle($title, $content, $user_id, $imageAllign);
				if(!empty($imagePath)) {
					// create the image filename based on the id of the title
					$filepath = IMAGE_SAVE_DIR.'/'.$page_id.'.png';
					// move the uploaded file into our image folder
					move_uploaded_file($imagePath, $filepath);
				}
				return true;
			}
		} catch (PDOException $ex) {
			trigger_error('Error saving article: '.$ex, E_USER_ERROR);
			return false;
		}
	}
	/*
	 * Deletes Article with given title
	 */
	public static function deleteArticle($title) {
		$db = db::getInstance();
		try {
			$article = Wiki::getArticle($title);
			if(!$article->isNew()) {
				// delete image file...
				$filename = $article->getId().'.png';
				$path = IMAGE_SAVE_DIR.'/'.$filename;
	
				if(file_exists($path)) {
					unlink($path);
				} 
				$db->deleteTitle($title);
			}
			
			return true;
		} catch (PDOException $ex) {
			trigger_error("Error deleting article: " . $ex, E_USER_ERROR);
			return false;
		}
	}
	/*
	 * Creates a new user with given name, email and password.
	 * This will result in a new user entry without admin privileges.
	 */
	public static function createUser($login, $email, $password) {
		// A higher "cost" is more secure but consumes more processing power
		$cost = 10;
		// Create a random salt
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		// Prefix information about the hash so PHP knows how to verify it later.
		// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		// Value:
		// $2a$10$eImiTXuWVxfM37uY4JANjQ==
		
		// Hash the password with the salt
		$hash = crypt($password, $salt);
			
		try {
			$db = db::getInstance();
			$db->createUser($login, $email, $hash, false);
			return true;
		} catch (PDOException $ex) {
			trigger_error("Error creating user: " . $ex, E_USER_ERROR);
			return false;
		}
		
	}
	
}

?>
