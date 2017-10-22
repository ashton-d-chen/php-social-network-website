<?php # Delete Photo

$page_title = 'delete_photo';
if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');



echo '<div id="content">';
if(isset($_SESSION['user_id']) && isset($_GET['album']) && isset($_GET['image'])) {	
	
	
	// Acquire deleted image's order id
	$q = "SELECT file_name, order_id FROM images WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}' AND image_id = '{$_GET['image']}'";
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	$oi = $a['order_id'];
	$fn = $a['file_name'];

	// count image number in the album
	$q = "SELECT COUNT(file_name) FROM images WHERE album_id=" . $_GET['album'];
	$r = @mysqli_query ($dbc, $q);
	$a = mysqli_fetch_array ($r, MYSQLI_NUM);
	$num = $a[0];
	
	// if deleted image is not at the end of line
	if ($oi != $num) {
		$cnt = 0;
		$pre = $cnt + $oi;
		$nxt = $cnt + $oi + 1;
		while ( $cnt < $num - $oi) {
			$q = "UPDATE images SET order_id = " . $pre . " WHERE album_id = 	'{$_GET['album']}' AND order_id = " . $nxt;
			$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			$cnt++;
		}			
	}

	// Delete image record 
	$q = "DELETE FROM images WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}' AND image_id = '{$_GET['image']}' LIMIT 1";
	@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

	
	// If album cover was deleted, reset album cover
	$q = "SELECT album_id FROM albums WHERE album_cover = '{$_GET['image']}'";
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	if (mysqli_num_rows($r) == 1) {
		$a = mysqli_fetch_array($r, MYSQLI_ASSOC);
		
		// Extract images id within the album
		$q = "SELECT image_id FROM images WHERE album_id = '{$a['album_id']}' ORDER BY order_id ASC" ;
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		$a = mysqli_fetch_array($r, MYSQLI_ASSOC);
					
		// update album cover value
		$q = "UPDATE albums SET album_cover = " . $a['image_id'] . " WHERE album_id = '{$_GET['album']}' LIMIT 1";
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
	}
	
	// If the deleted image is the last one in the album, delete the album
	if ($num == 1) {
		$q = "DELETE FROM albums WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}' LIMIT 1";
		@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	}
	
	// Delete image physical data on server
	
	chdir('uploads/' . $_SESSION['user_id'] . '/' . $_GET['album'] . '/' );
    
	$do = unlink('w_' . $fn);
	
	$do = unlink('u_' . $fn);
	
	$do = unlink('t_' . $fn);
	
	// Change working directory back
	chdir('../../../../photo/' );
    if($do=="1"){
        echo "The file was deleted successfully.";
    } else { echo "There was an error trying to delete the file."; } 
	
	// Redirect Back to Original Page
	mysqli_close($dbc);
	
	if (isset($_GET['tp']))	// If requested by other script
		header( 'Location: ../photo/index.php?tp=23498234&amp;album=' . $_GET['album'] );
		//echo '<br /> <h2>Photo deleted.</h2>';
	else 
		header( 'Location: ../photo/index.php?album=' . $_GET['album'] );
}
		
 // Include the HTML footer file:
 if (!isset($_GET['tp'])) 
	 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();
?>