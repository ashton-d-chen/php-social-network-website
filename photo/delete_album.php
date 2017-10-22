<?php # Delete Album
$page_title = 'delete_album';
if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');



echo '<div id="content">';

// Recursively Delete folder
 function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 } 	

if(isset($_SESSION['user_id']) && isset($_GET['album'])) {	
	
	
	////////// Delete Album Images from Database //////////
	$q = "DELETE FROM images WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}'";
	@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	////////// Delete Albme from Database //////////
	$q = "DELETE FROM albums WHERE user_id = '{$_SESSION['user_id']}' AND album_id = '{$_GET['album']}'";
	@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	////////// Delete File from Server //////////
	$path = 'uploads/' . $_SESSION['user_id'] . '/' . $_GET['album'] . '/';
	rrmdir($path);
	
	// Redirect Back to Original Page
	mysqli_close($dbc);
	
	if (isset($_GET['tp']))	// If requested by other script
		echo '<br /> <h2>Album deleted</h2>';
	else 
		header( 'Location: ../photo/index.php' );
}
		
 // Include the HTML footer file:
 if (!isset($_GET['tp'])) 
	 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();
?>