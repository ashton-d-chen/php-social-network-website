<?php
// Indicate the encoding:
// header ('Content-Type: text/html; charset=UTF-8');

// Start output buffering:
ob_start ();

// Initialize a session:
// if (!isset ($_COOKIE[ini_get('session.name')])) {
// session_start();
// }

session_start ();
// Web Configuration file
require_once ('../includes/config.inc.php');

// Connect to database
require_once (MYSQL);

// The language ID is stored in the session.
// Check for a new language ID...

$words;
$lid = 1;
if (isset ( $_GET ['lid'] ) && is_numeric ( $_GET ['lid'] )) {
	$_SESSION ['lid'] = ( int ) $_GET ['lid'];
} elseif (! isset ( $_SESSION ['lid'] )) {
	$_SESSION ['lid'] = 1; // Default.
}

// Get the words for this language.
$words = FALSE; // Flag variable.
if ($_SESSION ['lid'] > 0) {
	$q = "SELECT * FROM words WHERE lang_id = {$_SESSION['lid']}";
	$r = @mysqli_query ( $dbc, $q );
	if (mysqli_num_rows ( $r ) == 1) {
		$words = mysqli_fetch_array ( $r, MYSQLI_ASSOC );
	}
}

// If we still don't have the words, get the default language:
if (! $words) {
	$_SESSION ['lid'] = 2; // Default.
	$q = "SELECT * FROM words WHERE lang_id = {$_SESSION['lid']}";
	$r = @mysqli_query ( $dbc, $q );
	$words = mysqli_fetch_array ( $r, MYSQLI_ASSOC );
}

// Check for a $page_title value:

if (! isset ( $title )) {
	$page_title = $words ['aquasque'];
} else {
	$page_title = $words ['aquasque'] . " - " . $words ["{$title}"];
}

require_once ('../includes/sf/get_user_id.php');
$uid;
get_user_id ();

?>