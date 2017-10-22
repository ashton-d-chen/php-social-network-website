<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

if (isset($_GET['image'])){ // Request from another script
	include('includes/config.inc.php');
	include('includes/ini.inc.php');
	display_image($_GET['image']);
} else if (isset($pid)){
	
	display_image($pid);
} else {
	include('includes/config.inc.php');
	display_image(134);
}


function display_image($pid) {
		
		require_once('mysqli_connect_local.php');
	
		$q = "SELECT image_id, album_id, user_id, file_name FROM images WHERE image_id=" . $pid . " LIMIT 1";					
		$r = @mysqli_query ($dbc, $q);
		
		if ($r) {
			$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		 
			$p= "../photo/uploads" . "/" . $a['user_id'] . "/" . $a['album_id'] . "/w_" . $a['file_name'];
		
			echo '<a class="image" href="../photo/index.php?album=' . $a['album_id'] . '&amp;image=' . $a['image_id'] . '" alt="' . $a['image_id'] . '"><img src="' . $p . '" alt="' . $a['file_name'] . '"/></a>';
		}	
}
?>


</body>
</html>