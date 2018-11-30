<?php
	class Post {
		//DB properties
		private $conn;
		private $posts_table = 'myblog.posts';
		private $categories_table = 'myblog.categories';
				
		//Post properties
		public $id;
		public $category_id;
		public $category_name;
		public $title;
		public $body;
		public $author;
		public $created_at;
		
		//Contructor with DB
		public function __construct($db) {
			$this->conn = $db;
		}
		
		//Read all posts
		public function read() {
			$query = 'SELECT c.name AS category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM '.$this->posts_table.' p LEFT JOIN '.$this->categories_table.' c ON p.category_id = c.id ORDER BY p.created_at DESC';
			
			$statement = $this->conn->prepare($query);
			$statement->execute();
			
			return $statement;
		}
		
		//Read single post
		public function read_single($id) {
			$query = 'SELECT c.name AS category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM '.$this->posts_table.' p LEFT JOIN '.$this->categories_table.' c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';
			
			$statement = $this->conn->prepare($query);
			
			//Bind ID for question mark
			$statement->bindParam(1, $id);
			$statement->execute();
			
			return $statement;
		}
		
		
		//Create post
		public function create() {
			$query = 'INSERT INTO '.$this->posts_table.' SET title = :title, body = :body, author = :author, category_id = :category_id';
			
			$statement = $this->conn->prepare($query);
			
			//Clean data
			$this->title = htmlspecialchars(strip_tags($this->title));
			$this->body = htmlspecialchars(strip_tags($this->body));
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			
			//Bind data using named params
			$statement->bindParam(':title', $this->title);
			$statement->bindParam(':body', $this->body);
			$statement->bindParam(':author', $this->author);
			$statement->bindParam(':category_id', $this->category_id);
			
			// #Query using positional params
			// $query = 'INSERT INTO '.$this->posts_table.' SET title = ?, body = ?, author = ?, category_id = ?';
			
			// #Bind data using positional params
			// $statement->bindParam(1, $this->title);
			// $statement->bindParam(2, $this->body);
			// $statement->bindParam(3, $this->author);
			// $statement->bindParam(4, $this->category_id);
			
			if($statement->execute()) {
				return true;
			} else {
				printf("Error: %s.\n", $statement->error);				
				return false;
			}
		}
		
		
		//Update post
		public function update() {
			$query = 'UPDATE '.$this->posts_table.' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id = :id';
			
			$statement = $this->conn->prepare($query);
			
			//Clean data
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->title = htmlspecialchars(strip_tags($this->title));
			$this->body = htmlspecialchars(strip_tags($this->body));
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			
			//Bind data using named params
			$statement->bindParam(':id', $this->id);
			$statement->bindParam(':title', $this->title);
			$statement->bindParam(':body', $this->body);
			$statement->bindParam(':author', $this->author);
			$statement->bindParam(':category_id', $this->category_id);
		
			if($statement->execute()) {
				return true;
			} else {
				printf("Error: %s.\n", $statement->error);				
				return false;
			}
		}
		
		public function delete_post() {
			$query = 'DELETE FROM '.$this->posts_table.' WHERE id = :id';
			$statement = $this->conn->prepare($query);
			
			$this->id = htmlspecialchars(strip_tags($this->id));
			$statement->bindParam('id', $this->id);
			
			if($statement->execute()) {
				return true;
			} else {
				printf('Error: %s.\n', $statement->error);
				return false;
			}
		}
	}
?>
