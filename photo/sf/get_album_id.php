<?
// Search database for album id by album name
function get_album_id($user_id, $album_name, $database_connection) {
	$q = "SELECT album_id FROM albums WHERE album_name='$album_name' AND user_id = '$user_id'";
	$r = mysqli_query ($database_connection, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($database_connection));
	if (mysqli_num_rows($r) == 1) { // if select query executes successfully
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);  // save query result to array
		$album_id = $row['album_id'];	// assign album_id to aid variable	
		return $album_id;
	} else {
		return false;
	}
}	
?>