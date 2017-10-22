<?php # home.php
// This is user's home page

// Configuration File
require_once ('../includes/config.inc.php'); 

// Set page title
//$page_title = 'Profile';

// include header.inc.php
include (HEADER);

if (isset($_SESSION['user_id'])) {

	// retrive user information by querying the database:
	$q = "SELECT self_intro FROM users WHERE user_id = " . $_SESSION['user_id'] . " AND active IS NULL";		
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	if (@mysqli_num_rows($r) == 1) { // A match was made.

		// Register the values & redirect:
		$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
		mysqli_free_result($r);
		mysqli_close($dbc);
						
		echo $row['self_intro'];	
	} else { // No match was made.
		echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
	}
	// output a profile photo
	
	// output a personal description
	
	// being able to create personal album and upload photo
	
	// being able to edit profile

} else {  // if user is not signed in
	
	// redirect the user to home page
	header ("Location: " + "..home/index.php");
	exit();
}

// includes footer.inc.php
include (FOOTER);

?>