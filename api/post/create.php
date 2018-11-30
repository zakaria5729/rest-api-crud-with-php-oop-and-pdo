<?php
	//header for access type
	header('Access-Control-Allow-Origin: *'); //* for allow publicly
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); //define what is allowed in header (X-Requested-With helps to prevent cross site scripting attack)
	
	require_once '../../config/Database.php';
	require_once '../../models/Post.php';

	//Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();
	
	//Instantiate blog post object
	$post = new Post($db);
	
	//Get raw posted data
	$data = json_decode(file_get_contents('php://input'));
		
	if($data != null && !empty($data)) {
		$post->title = $data->title;
		$post->body = $data->body;
		$post->author	= $data->author;
		$post->category_id = $data->category_id;
		
		if(trim($post->title) != false && trim($post->body) != false && trim($post->author) != false && trim($post->category_id) != false) {
			//Create post and insert to DB
			if($post->create()) {
				echo json_encode(array('message' => 'Post created'));
			} else {
				echo json_encode(array('message' => 'Post not created'));
			}
		} else {
			echo json_encode(array('message' => 'Post not created. Must be filled up all the fields'));
		}
	} else {
		echo json_encode(array('title'=> 'Dummy title', 'body'=> 'Dummy Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'author'=> 'Dummy author', 'category_id' => '1'));
	}
?>	
