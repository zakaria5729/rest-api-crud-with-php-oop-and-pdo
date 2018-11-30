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
	
	//Get ID from (read_single.php?id=7)
	$post_id = isset($_GET['id']) ? $_GET['id'] : die();
	
	//Blog post query for single post
	$result = $post->read_single($post_id);
	$num_of_row = $result->rowCount();
	
	if($num_of_row > 0) {
		//Fetch single post
		$row = $result->fetch(PDO::FETCH_ASSOC);
		extract($row);
	
		//Create array
		$post_array = array('id'=>$post_id, 'title'=>$title, 'body'=>html_entity_decode($body), 'author'=>$author, 'category_id'=>$category_id, 'category_name'=>$category_name, 'created_at'=>$created_at));
		
		//Make JSON data
		print_r(json_encode($post_array));
		//echo json_encode($post_array);
	} else {
		echo json_encode(array('message' => 'No data found'));
	}
?>