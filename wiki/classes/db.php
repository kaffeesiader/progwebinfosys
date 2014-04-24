<?php

/*
 * Abstract base class for our database access.
 * Holds a singleton instance of a concrete implementation, based on our settings (optimized, or not).
 * 
 */
abstract class db {
	
	private static $instance;
	// instance of the PDO database connection
	protected  $db;
	
	public function __construct() {
		include_once 'dbconfig.php';
		// create a connection based on our database settings
		$db = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
		$this->db = $db;
	}
	
	public function __destruct() {
		// destruct db object...
		$this->db = null;
	}
	/*
	 * Create a new user, with given username, email and password.
	 * The type is set to 0 by default (not an admin user)
	 */
	public function createUser($username, $email, $pwhash, $type = 0) {
		$db = $this->db;
		
		$stmt = $db->prepare('INSERT INTO users (username, email, password, usertype) 
										VALUES (?, ?, ?, ?)');
		
		$stmt->bindValue(1, $username, PDO::PARAM_STR);
		$stmt->bindValue(2, $email, PDO::PARAM_STR);
		$stmt->bindValue(3, $pwhash, PDO::PARAM_STR);
		$stmt->bindValue(4, $type, PDO::PARAM_INT);
		
		return $stmt->execute();
	}
	/*
	 * Get a user by it's name
	 */
	public function getUser($username) {
		$db = $this->db;
		
		$stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
		$stmt->execute(array($username));
		return $stmt->fetch(PDO::FETCH_OBJ);
	}
	/*
	 * Execute a given query with an array of params
	 * and return an assoziated array, containing the results
	 */
	public function executeQuery($query, $params) {
		$db = $this->db;
		
		$stmt = $db->prepare($query);
		$stmt.execute($params);
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	/*
	 * Find titles that match given query string. 
	 */
	public function findTitles($query, $start_index, $max_results) {
		$db = $this->db;
		// create an sql statement
		$sql = "SELECT title FROM pages
					WHERE title LIKE ?
					ORDER BY title
					LIMIT ?, ?";
		// let the db connection prepare a statement object
		$stmt = $db->prepare($sql);
		$like = '%'.$query.'%';
		// assign parameter values (one for each '?')
		$stmt->bindValue(1, $like, PDO::PARAM_STR);
		$stmt->bindValue(2, $start_index, PDO::PARAM_INT);
		$stmt->bindValue(3, $max_results, PDO::PARAM_INT);
		// execute the statement
		$stmt->execute();
		// fetch the result with one of the predifined fetch types (FETCH_COLUMN, FETCH_ASSOC, FETCH_OBJ)
		$rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

		return $rows;
	}
	/*
	 * Get the amount of records, matching given query string.
	 */
	public function getResultCount($query) {
		$db = $this->db;
		$stmt = $db->prepare("SELECT COUNT(*) FROM pages WHERE title LIKE ?");
		$like = '%'.$query.'%';
		$stmt->execute(array($like));
		
		return $stmt->fetch(PDO::FETCH_COLUMN);
	}
	/*
	 * Get the title with given name
	 */
	public function getTitle($name) {
		$db = $this->db;

		$sql = "SELECT p.id, p.title, p.content, p.creationDateTime, p.editDateTime, cru.username as creator, edu.username as editor, p.imageAllign
 					FROM pages p
					INNER JOIN users edu ON edu.id = p.editedBy
					INNER JOIN users cru ON cru.id = p.createdBy
					WHERE (title = ?)";

		$stmt = $db->prepare($sql);
		$stmt->execute(array($name));
		// returns an assoziated array where keys are the field names
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	
	/*
	 * Save a title with given content. This will create a new title or replace an existing one.
	 */
	public function saveTitle($name, $content, $user, $imageAllign) {
		$db = $this->db;
		// here we use a transaction because the insert involves several statements
		$db->beginTransaction();
		try {
			// save page first (or update existing one...)
			$sql = "INSERT INTO pages (title, content, creationDateTime, createdBy, editedBy, imageAllign)
						VALUES (?, ?, NOW(), ?, ?, ?)
						ON DUPLICATE KEY UPDATE content=?, editedBy=?, imageAllign=?";
			
			$stmt = $db->prepare($sql);
			$stmt->bindValue(1, $name, PDO::PARAM_STR);
			$stmt->bindValue(2, $content, PDO::PARAM_STR);
			$stmt->bindValue(3, $user, PDO::PARAM_INT);
			$stmt->bindValue(4, $user, PDO::PARAM_INT);
			$stmt->bindValue(5, $imageAllign, PDO::PARAM_STR);
			$stmt->bindValue(6, $content, PDO::PARAM_STR);
			$stmt->bindValue(7, $user, PDO::PARAM_INT);
			$stmt->bindValue(8, $imageAllign, PDO::PARAM_STR);
			
			$stmt->execute();
			// ... then obtain the page_id...
			$stmt = $db->prepare("SELECT id FROM pages WHERE title = ?");
			$stmt->execute(array($name));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$page_id = $result['id'];
			// ... remove all existing link entries ...
			$stmt = $db->prepare("DELETE FROM links WHERE pageId = ?");
			$stmt->bindValue(1, $page_id, PDO::PARAM_INT);
			$stmt->execute();
			//... and save referenced pages
			$linked_titles = Article::getLinkedTitles($content);
			
			foreach ($linked_titles as $title) {
				// insert one datarow for each link
				$sql = "INSERT INTO links (pageId, linkedTitle) VALUES (?, ?)";
				$stmt = $db->prepare($sql);
				$stmt->bindValue(1, $page_id, PDO::PARAM_INT);
				$stmt->bindValue(2, $title, PDO::PARAM_STR);
				$stmt->execute();
			}	
			// commit the transaction
			$db->commit();
			// return the id of the newly created page
			return $page_id;
			
		} catch (PDOException $ex) {
			// rollback the transaction in case of an error
			$db->rollback();
			throw $ex;
		}
		
	}
	/*
	 * Generate and save multiple titles with generated content. 
	 * This will create new titles or replace existing ones.
	*/
	public function generateMultipleTitles($titles, $contents, $number) {
		$db = $this->db;
		$userId = $_SESSION['user_id'];		
		// build up sql string with multiple generated tiltes
		$sql = "INSERT INTO pages (title, content, createdBy, creationDateTime, editedBy) VALUES ";
		for ($i = 0; $i < $number; $i++) {
			if($i < $number -1)
				$sql .= "('$titles[$i]','$contents[$i]', $userId, NOW(), $userId),";
			else 
				$sql .= "('$titles[$i]','$contents[$i]', $userId, NOW(), $userId)";
		}
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
	/*
	 * Delete the title with given name.
	 */
	public function deleteTitle($title) {
		$db = $this->db;
		$stmt = $db->prepare("DELETE from pages WHERE title=?");
		return $stmt->execute(array($title));
	}
	/*
	 * Return a list of titles that contain a reference to given title
	 */
	public abstract function getReferencingTitles($title);
	/*
	 * Return the number of titles containing a recerence to given title
	 */
	public abstract function getReferencingTitlesCount($title);
	/*
	 * Get the current instance. This returns a db instance based on our settings (optimized or not)
	 */
	public static function getInstance() {
		if(!isset(db::$instance)) {
			db::$instance = db::createInstance();
		}
		return db::$instance;
	}
	/*
	 * Create a new db instance based on the settings value
	 */
	private static function createInstance() {
		$optimized = Settings::getOptimizationOn();
		
		if($optimized) {
			return new optimized_db();
		} else {
			return new default_db();
		}
	}
} 
/*
 * DB implementation without optimization
 */
class default_db extends db {
	
	public function getReferencingTitles($title) {
		$db = $this->db;
		$like = '%[['.$title.']]%';
		$stmt = $db->prepare("SELECT title FROM pages WHERE content LIKE ?");
		$stmt->bindValue(1, $like, PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	}
	
	public function getReferencingTitlesCount($title) {
		$db = $this->db;
		
		$sql = "SELECT COUNT(*) FROM pages WHERE content LIKE ?";
		
		$stmt = $db->prepare(sql);
		$stmt->execute(array($title));
	
		return $stmt->fetch(PDO::FETCH_COLUMN);
	}
	
}
/*
 * DB implementation, optimized for searching
 */
class optimized_db extends db {

	public function getReferencingTitles($title) {
		$db = $this->db;
		
		$sql = "SELECT po.title FROM pages po
					INNER JOIN links l ON po.id = l.pageId
					WHERE l.linkedTitle = ?
					LIMIT 30";
		
		$stmt = $db->prepare($sql);
		$stmt->execute(array($title));
		
		return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	}
	
	public function getReferencingTitlesCount($title) {
		$db = $this->db;
		
		$sql = "SELECT COUNT(*) FROM pages po
					INNER JOIN links l ON po.id = l.pageId
					WHERE l.linkedTitle = ?";
		
		$stmt = $db->prepare(sql);
		$stmt->execute(array($title));
	
		return $stmt->fetch(PDO::FETCH_COLUMN);
	}
}

?>
