<?php # logout.php
// This is the logout page for the site.

//require_once ('../includes/config.inc.php'); 
$page_title = 'logout';


if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['first_name'])) {
	$url = BASE_URL . 'home/index.php?tp=839'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	//header("Location: $url");
	header('Location: ' . BASE_URL . '/home/index.php');
} else { // Log out the user.
	$_SESSION = array(); // Destroy the variables.
	
	setcookie (session_name(), '', time()-30000); // Destroy the cookie.
	session_destroy(); // Destroy the session itself.
    // return message for button
	header('Location: ' . BASE_URL . '/home/index.php');
	echo '<a href="#" id="loginout" title="';
	if (isset($_SESSION['user_id'])) {echo $words['logout'];} else {echo $words['login'];}
	
	echo '">';
	if (isset($_SESSION['user_id'])) {echo $words['logout'];} else {echo $words['login'];}
	echo '</a>';
}

 // Include the HTML footer file:
 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>
