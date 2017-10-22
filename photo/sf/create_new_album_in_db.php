<?php
// Create a new album in database
function create_new_album_in_db($user_id, $new_album_name){
	global $dbc;
	// find album id
	$q = "SELECT order_id FROM albums WHERE user_id='$user_id' ORDER BY order_id DESC";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	$album_order = 0;
	// If there is at least one album 
	if($r) {
		$album_order = mysqli_fetch_array($r, MYSQLI_NUM);
		$album_order = $album_order[0] + 1;
	} else {
		$album_order = 0;
	}
	
	$q = "INSERT INTO albums (user_id, created_date, album_name, order_id) VALUES ($user_id, NOW(), '$new_album_name' ,$album_order)";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	$new_album_id = mysqli_insert_id($dbc);
	return $new_album_id;
}
?>