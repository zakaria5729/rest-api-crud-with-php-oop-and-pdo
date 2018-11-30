<?php
	//header for access type
	header('Access-Control-Allow-Origin: *'); //* for allow publicly
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); //define what is allowed in header (X-Requested-With helps to prevent cross site scripting attack)
	
	require_once '../../config/Database.php';
	require_once '../../models/Post.php';

	//Instantiate DB and connect
	$database = new Database();
	$db = $database->connect();
	
	//Instantiate blog post object
	$post = new Post($db);
	
	$isId = false;
	
	//Get entered data for update
	$data = json_decode(file_get_contents('php://input'));
		
	if($data != null && !empty($data)) {
		//Check if id is exists or not
		$query_id = 'SELECT id FROM myblog.posts WHERE id = ?';
		$statement = $db->prepare($query_id);
		
		$statement->bindParam(1, $data->id);
		$statement->execute();
		
		//Fetch column of id
		$result_id = $statement->fetchColumn();
		
		if($result_id > 0) {
			$post->id = $data->id;
			
			//Delete post from DB
			if($post->delete_post()) {
				echo json_encode(array('message' => 'Post Deleted'));
			} else {
				echo json_encode(array('message' => 'Post not Deleted'));
			}
		} else {
			echo json_encode(array('message'=> 'Invalid id'));
		}
	} else {
		echo json_encode(array('id'=> '1'));
	}
?>	
