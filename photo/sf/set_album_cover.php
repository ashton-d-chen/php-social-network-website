<?php
// Set album cover
function set_album_cover($new_image_id, $album_id){
	global $dbc;
	$q = "UPDATE albums SET album_cover =" . $new_image_id . " WHERE album_id =" . $album_id;
	$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));	
}
?>