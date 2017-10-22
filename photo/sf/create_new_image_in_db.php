<?php
// Create new image entry in database
function create_new_image_in_db($user_id, $album_id, $new_image_name) {
	global $log, $dbc;
	$log->info("create_new_image function");
	
	// determine upload file order id by counting number of file in destination folder
	$image_count = count(glob(IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id. "/*"))/3 + 1 ;
	
	// insert image info
	$q = "INSERT INTO images (album_id, user_id, order_id, upload_date, file_name) VALUES ($album_id, $user_id, $image_count, NOW(), '$new_image_name' )";
	mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	$new_image_id = mysqli_insert_id($dbc);
	return $new_image_id;
}
?>