<?php # Delete Thread
// Configuration File
require_once ('../includes/config.inc.php'); 

$page_title = 'delete_thread';
include (HEADER);


if(isset($_SESSION['user_id']) && isset($_GET['tid'])) {	
	
	// Verify if user does own the 
	$q = "SELECT user_id FROM threads WHERE thread_id = '{$_GET['tid']}'";
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	if (mysqli_num_rows($r) == 1){
		$a = mysqli_fetch_array($r, MYSQLI_ASSOC);
		if ( $a['user_id'] == $_SESSION['user_id']) {
			 
			// Remove related posts from database
			$q = "DELETE FROM posts WHERE thread_id = '{$_GET['tid']}'";
			@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
			$q = "DELETE FROM threads WHERE thread_id = '{$_GET['tid']}'";
			@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		}
	}	
}
//header( 'Location: ' . BASE_URL . 'forum/index.php' );	
include (FOOTER);
?>