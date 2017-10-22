<?php
function get_image($str, $type){
	global $dbc;
	$q = "SELECT image_id, album_id, user_id, file_name, description, order_id FROM images WHERE $str";					
	$r = @mysqli_query ($dbc, $q);
	if ($r) {
		$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);		
		$a['image_path'] = IMAGE_UPLOAD_URL . "/" . $a['user_id'] . "/" . $a['album_id'] . "/" . $type . "_" . $a['file_name']; 
		return $a;
	} else 
		return FALSE;
}

function get_images($str, $type){
	global $dbc;
	$q = "SELECT image_id, album_id, user_id, file_name, order_id FROM images WHERE $str";
	$r = @mysqli_query ($dbc, $q);
	if ($r) {
		$a;
		for ($c=0; $c < mysqli_num_rows($r); $c++) {
			$a[$c] = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$a[$c]['image_path'] = IMAGE_UPLOAD_URL . "/" . $a[$c]['user_id'] . "/" . $a[$c]['album_id'] . "/" . $type . "_" . $a[$c]['file_name']; 
		} 
		return $a;
	} else 
		return FALSE;
}

?>