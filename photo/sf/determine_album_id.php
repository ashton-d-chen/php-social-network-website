<?php // get album id

function determine_album_id(){
	global $uid, $caid, $log;
	$album_id;
	
	$log->info("get_album_id function");
	// Decide which album id for query
	// Determine which album to display
	require_once(DOCUMENT_ROOT . '/photo/sf/get_album.php');
	
	if(isset($_GET['album'])) { // If album is specified in URL
		$album_id = $_GET['album'];	
		$log->debug("Got album id from GET", "\$album_id", $album_id);
		
		// Verify that album exist
		$a = get_album("user_id=$uid AND album_id=$album_id ORDER BY album_id");
		if($a){
			$caid = $album_id;
			$log->info("Found the album in database");
			return true;
		} else {
			$log->info("Couldn't find the album in database");
			return false;
		}
	} if (isset($caid)) {
		$log->debug("Got album id from $caid", "\$caid", $caid);
	} else { // if album was not specified, get album from database
		
		$a = get_album("user_id=$uid ORDER BY album_id");
		if($a) {
			$caid = $a['album_id'];
			return true;
		}  else  {
			//$e = TRUE;
			//echo "can't get album id";
			if (isset($_GET['tp'])) {
				//echo $uid . " errorr " . $caid; 
				//header('Location: ../photo/select_album_for_upload.php?tp=3242');
			}  else {
				//echo $uid . " errorr " . $caid; 

				//header('Location: ../photo/select_album_for_upload.php');
			}
			return false;
		 }
	}
}

?>
