<?php
	//header for access type
	header('Access-Control-Allow-Origin: *'); //* for allow publicly
	header('Content-type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Post.php';

	//Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();
	
	//Instantiate blog post object
	$post = new Post($db);
	
	//Blog post query
	$result = $post->read();
	$num_of_row = $result->rowCount();
	
	if($num_of_row > 0) {
		$posts_array['posts'] = array(); //initialize data index with the blank array
		//$posts_array = array();
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			// $id = $row['id'];
			// $title = $row['title'];
			// $body = $row['body'];
			// $author = $row['author'];
			// $category_id = $row['category_id'];
			// $category_name = $row['category_name'];
			
			//extract all the data and this is like $row['title'], $row['body']
			extract($row);
			
			$posts_item = array('id'=>$id, 'title'=>$title, 'body'=>html_entity_decode($body), 'author'=>$author, 'category_id'=>$category_id, 'category_name'=>$category_name, 'created_at'=>$created_at); //html_entity_decode() function is used to convert all HTML entities to their applicable characters
			
			//Push to $post_array
			array_push($posts_array['posts'], $posts_item);
			//array_push($posts_array, $posts_item);
		}
		
		//Make JSON data
		echo json_encode($posts_array);
		//echo json_encode(array('page'=>2, 'total'=>5, 'data'=>$posts_array));
		
	} else {
		echo json_encode(array('message'=> 'No data found'));
	}
	
?>