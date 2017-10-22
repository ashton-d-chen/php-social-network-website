<?php # A gallery with image slider show

$page_title = 'gallery';
if (!isset($_GET['tp']))
	include_once('../includes/header.inc.html');
else
	include_once('../includes/ini.inc.php');


// Variables
$aid; // default album id 
$pid;
$caname = "";  // current album name
$count = 0;
//$uid = 1; // user id
$image = 0; // image variable
$current_page_url = "../photo/index.php"; // For cancel button return

$a = 0;
$caid;
$cpid;
$ok = TRUE;

include('sf/get_album.php');
include('sf/get_image.php');

$log->debug("Get user ID", "\$uid", $uid);

// Get album id
include('sf/determine_album_id.php');
if(determine_album_id()){
	$log->debug("Get album ID", "\$caid", $caid);
} else {
	$ok = FALSE;
}


// Display content
echo '<div id="content">';	

// Display side menu
if (isset($_SESSION['user_id'])){
	include('sf/display_menu.php');
} 

echo '<div id="display">';


// Determine which user's album to display
$log->info("Determine which user's album to display");


if ($ok){
	// Display album preview
	$album_preview_destinaiton = "../photo/index.php";
	include('sf/album_preview.php');
	display_album_preview($uid, $caid, $album_preview_destinaiton);


	// Display Album Name
	$a = get_album("album_id=$caid LIMIT 1");
	if ($a) {
		echo '<br /><div id="album_name_container">' . $a['album_name'] . '</div>'; 
	} else {
		echo "<h2>Error: Can't find the album and the photo.</h2>";	

	}



	// Determine current image id
	$log->info("Determine current image ID");
	if (isset($_GET['image'])) {
		$pid = $_GET['image'];
		$a =  get_image("user_id=$uid AND user_id=$uid AND album_id=$caid AND image_id=$pid", "");
		if(!$a)
			$e = TRUE;
		else 
			$cpid = $_GET['image'];
			$log->debug("Got image id", "\$cpid", $cpid);
	} else if (isset($caid)) {
		$log->debug($page_title, "\$uid", $uid);
		$log->debug($page_title, "\$caid", $caid);
		
		$a =  get_image("user_id=$uid AND album_id=$caid ORDER BY order_id", "");
		if(!$a) {// Cannot find image
			//$e = TRUE;
			//echo 'test exit';
			//exit();
			//header('Location: ../photo/select_album_for_upload.php');
			//exit();
		}
		else {
			$cpid = $a['image_id'];
			$log->debug($page_title, "\$cpid", $cpid);
		}
	} else {
		//echo "yes";
	}


////////// Display Images //////////

// Set Album ID
if ( (isset($_GET['album'])) && (is_numeric($_GET['album'])) ) { // From view_users.php
	$caid = $_GET['album'];
} 



// Large Image View

echo '<div id="image_container" >';

// Aquire Image Path
$file = "../photo/uploads" . "/" . $uid . "/" . $caid . "/u_" . $image;

// Display Image
$pid = $cpid;
include('sf/display_image.php');


// Display Photo Description
$q = "SELECT description FROM images WHERE image_id = " . $pid ;
$r = @mysqli_query ($dbc, $q);
$a = mysqli_fetch_array($r, MYSQLI_ASSOC);



/*

echo '<div class="apple_overlay black" id="photo">
	<img src="' . "../photo/uploads" . "/" . $uid . "/" . $caid . "/w_" . $image . '" alt="' . $image . '"/>';





echo '
	<div class="details">
		<h2>' . $a['description'] . '</h2>

		<p>
			The Gustavo House in Storkower Strasse. It was built in 1978 and reconstructed in
			1998 by the Spanish artist Gustavo.
		</p>
	</div>
</div>'; // End of apple overlay black
*/
}

echo '</div>'; // End of image container


// Diaplay album image preview
include_once(DOCUMENT_ROOT . '/photo/sf/album_image_preview.php');

// end of display
echo '</div>';

// end of content
echo '</div>';


?>


<?php // Display log
if (!LIVE) {
	$log->display();
} 
?>

<?php
echo '<script type="text/javascript">$.getScript("../photo/js/photo.js");</script>';
echo '<script type="text/javascript">$.getScript("../photo/js/return.js");</script>';
echo "<script> $('#current_page').attr('data-current-page','../photo/index.php');</script>";

 // Include the HTML footer file:
 if (!isset($_GET['tp'])) 
	 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();
?>