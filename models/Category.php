<?php
	class Category {
		private $categories_table = 'myblog.categories';
		private $conn;
		
		public $id;
		public $name;
		public $created_at;
		
		public function __construct($db) {
			$this->conn = $db;
		}
		
		public function read() {
			$query = 'SELECT * FROM '.$this->categories_table.' ORDER BY created_at DESC';
			
			$statement = $this->conn->prepare($query);
			$statement->execute();
			
			return $statement;
		}
	}
?>
