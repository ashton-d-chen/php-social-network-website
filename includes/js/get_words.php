<?php

if (!function_exists("get_image"))
	require_once('get_image.php');

if (isset($_GET['words']) && isset($_SESSION['lid'])){ // Request from client
	$wid = $_GET['words'];
	$lid = $_SESSION['lid'];
} else if (isset($pid)){ // Request from another script

} else {
	exit();	
}

// Check current working folder
if (strstr(getcwd(), 'sf') != "") {
	chdir('../');
	include('../includes/config.inc.php');
	require_once(MYSQL);			
}

$q = "SELECT " .  $wid . " FROM languages WHERE lang=$lid";
$r = mysqli_query($dbc, $q);
if($r){
	$a = mysqli_fetch_array($r, MYSQLI_NUM)	;
	return $a[0];
}
?>
