<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';
	
	$database = new Database();
	$db = $database->connect();
	
	$category = new Category($db);
	$result = $category->read();
	
	$num_of_row = $result->rowCount();
	
	if($num_of_row > 0) {
		$category_array['category'] = array();
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			$category_item = array('id'=>$id, 'name'=>$name, 'created_at'=>$created_at);
			
			array_push($category_array['category'], $category_item);
		}		
		echo json_encode($category_array);

	} else {
		echo json_encode(array('message' => 'No categories found'));
	}
?>
