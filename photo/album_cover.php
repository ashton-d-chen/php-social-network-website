<?php # Set Album Cover
// Configuration File
require_once ('../includes/config.inc.php'); 

$page_title = 'set_album_cover';
if (!isset($_GET['tp'])) {
	include('../includes/header.inc.html');
}else
	include('../includes/ini.inc.php');

	

if(isset($_SESSION['user_id']) && isset($_GET['album']) && isset($_GET['image'])) {	
		
	// Update Album Name
	$q = "UPDATE albums SET album_cover = '{$_GET['image']}' WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}' LIMIT 1";
	@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	// Redirect Back to Original Page
	mysqli_close($dbc);
	
	if (isset($_GET['tp']))	// If requested by other script
		header( 'Location: ../photo/index.php?tp=234234&amp;album=' . $_GET['album'] . '&image='. $_GET['image'] );
		//echo '<br /> <h2>Album cover is set.</h2>';
	else 
		header( 'Location: ../photo/index.php?album=' . $_GET['album'] . '&image='. $_GET['image'] );
}

		

 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();

?>