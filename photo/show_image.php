<?php # index.php
// This is the main page for the site.

// Include the configuration file:
// require_once ('../includes/config.inc.php'); 

// Configuration File
require_once ('../includes/config.inc.php'); 

// Set the page title and include the HTML header:
//$page_title = '';
include (HEADER);

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}!";
}
echo '</h1>';
?>

<?php # show_image.php
// This page displays an image.

$name = FALSE; // Flag variable:

// Check for an image name in the URL:
if (isset($_GET['image'])) {

	// Full image path:
	$image = "./uploads/{$_GET['image']}";

	// Check that the image exists and is a file:
	if (file_exists ($image) && (is_file($image))) {
	
		// Make sure it has an image's extension:
		$ext = strtolower ( substr ($_GET['image'], -4));
		
		if (($ext == '.jpg') OR ($ext == 'jpeg') OR ($ext == '.png')) {
			// Set the name as this image:
			$name = $_GET['image'];
		} // End of $ext IF.
		
	} // End of file_exists() IF.
	
} // End of isset($_GET['image']) IF.

// If there was a problem, use the default image:
if (!$name) {
	$image = './uploads/unavailable.png';	
	$name = 'unavailable.png';
}

// Get the image information:
$info = getimagesize($image);
$fs = filesize($image);

// Send the content information:
header ("Content-Type: {$info['mime']}\n");
header ("Content-Disposition: inline; filename=\"$name\"\n");
header ("Content-Length: $fs\n");

// Send the file:
readfile ($image);
		
?>

<?php // Include the HTML footer file:
include (FOOTER);
?>