<?php # Randomize image order

// Configuration File
$page_title = 'randomize_image_order';
if (!isset($_GET['tp'])) // If Ajax
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');


if(isset($_SESSION['user_id']) && isset($_GET['album'])) {
	$uid = $_SESSION['user_id'];
	$caid = $_GET['album'];
	
	// Randomly order images in a album

	$q = "SELECT COUNT(file_name) FROM images WHERE user_id=$uid AND album_id=$caid";
	$r = @mysqli_query ($dbc, $q);
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	$num = $row[0];
	for ($count = 0; $count < $num-1; $count += 1) {

		$g = rand(1, $num);
		$h = rand(1, $num);
		while ($h == $g) {
			$h = rand(1, $num);
		}

		$q = "SELECT image_id FROM images WHERE order_id = $g";
		$r = @mysqli_query ($dbc, $q);
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		$first = $row[0];
		
		$q = "SELECT image_id FROM images WHERE order_id = $h";
		$r = @mysqli_query ($dbc, $q);
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		$second = $row[0];
		
		$q = "UPDATE  images SET order_id = $h WHERE image_id = $first LIMIT 1";
		$r = @mysqli_query ($dbc, $q);
		
		$q = "UPDATE  images SET order_id = $g WHERE image_id = $second LIMIT 1";
		$r = @mysqli_query ($dbc, $q);
	
	}
	header( 'Location: ' . BASE_URL . '/photo/index.php?tp=239823');
	exit;
	//echo "Photo Randomization is completed.";
	// create a random number

}



if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>