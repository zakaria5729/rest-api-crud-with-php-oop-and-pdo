<?php
	class Database {
		private $host_name = 'localhost';
		private $db_name = 'myblog';
		private $user_name = 'root';
		private $password = '';
		private $conn;
		
		public function connect() {
			$this->conn = null;
			
			try {
				// new PDO('mysql:host = localhost; dbname = myblog', username, password)
				$this->conn = new PDO('mysql:host = '.$this->host_name.'; dbname = '.$this->db_name, $this->user_name, $this->password);
				
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			} catch(PDOException $e) {
				echo 'Connection error: '.$e->getMessage();
			}
			
			return $this->conn;
		}
	}
?>
