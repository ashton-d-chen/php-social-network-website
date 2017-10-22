<?php
function get_album($str){
	global $dbc;
	// Set up database connection
	//$dbc;
	if ($dbc == NULL) {
		chdir('../');
		require_once('../includes/ini.inc.php');
		require_once(MYSQL); 
	}
	$q = "SELECT album_id, album_name, album_cover, order_id FROM albums WHERE $str";
	$r = mysqli_query ($dbc, $q);
	if ($r) {
		$a = mysqli_fetch_array($r, MYSQLI_ASSOC);
		return $a;
	} else 
		return FALSE;
}

function get_albums($str){
	global $dbc;
	$a;
	$q = "SELECT album_id, album_name, album_cover, order_id FROM albums WHERE $str";
	$r = @mysqli_query ($dbc, $q);
	if ($r) {
		for ($c=0; $c < mysqli_num_rows($r); $c++) {
			$a[$c] = mysqli_fetch_array($r, MYSQLI_ASSOC);
		} 
		return $a;
	} else 
		return FALSE;
}



?>