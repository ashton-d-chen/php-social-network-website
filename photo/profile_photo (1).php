<?php # Set Profile Photo
// Configuration File
$page_title = 'set_profile_photo';
if (!isset($_GET['tp'])) // If Ajax
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');



if(isset($_SESSION['user_id']) && isset($_GET['image'])) {	
		
	// Acquire Current Profile Photo
	$q = "SELECT image_id FROM images WHERE user_id = '{$_SESSION['user_id']}' AND profile = 1";
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	$t = mysqli_num_rows($r);
	// If there exists a different current profile photo 
	if ($t == 1) {
		$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		if ($a['image_id'] != $_GET['image']) {
			// Remove current profile photo
			$q = "UPDATE images SET profile = 0 WHERE image_id = '{$a['image_id']}'";
			$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		} 
	}
	
	// Set selected photo as profile photo
	if ($t == 0 || (($t == 1) && ($a['image_id'] != $_GET['image']))) {
		$q = "UPDATE images SET profile = 1 WHERE image_id = '{$_GET['image']}'";
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	}
	
	if (isset($_GET['tp']))	{// If requested by other script
		//echo '<br /> <h2>Profile photo is set.</h2>';
		header( 'Location: ' . BASE_URL . '/profile/index.php?tp=239823');
		exit;
	} else { 
		header( 'Location: ../photo/index.php?album=' . $_GET['album'] . "&image=" . $_GET['image'] );
		exit;
	}
}

		
?>

<?php // Include the HTML footer file:
 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>