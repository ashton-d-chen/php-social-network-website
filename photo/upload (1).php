<?php # upload an image file


$page_title = 'upload_images';
// This page shows the threads in a forum.
// Configuration File
if (!isset($_GET['tp']) && !isset($_POST['tp'])) {
	include('../includes/header.inc.html');

} else {
	include('../includes/ini.inc.php');
}

// Initialize a logger
$log = new Log;	
$image_uploaded = false;

if(isset($_POST['submit'])){
	if (isset ($_FILES['new_image'])){
		if(isset($_SESSION['user_id'])) {
			if(isset($_POST['existing_album_id']) || $_POST['new_album_name']){
				$user_id = $_SESSION['user_id'];
							$new_image_name = $_FILES['new_image']['name'];
				$temp_file_name = $_FILES['new_image']['tmp_name'];	// read in temporary file name
				$log->debug("Got temporary file name", "\$temp_file_name", $temp_file_name);
				$new_album_name;
				$album_id;
				
				//$imagename = MD5($new_image_name);	// read in upload file name	
				

				$album_exist = false;
				// Determine if a new album should be create of an existing album should be used
				if(!empty($_POST['existing_album_id'])){
					$album_id = $_POST['existing_album_id'];
					$log->debug("Album exists","\$album_id",$album_id);
					$album_exist = true;
				} else if (!empty($_POST['new_album_name'])){
					$new_album_name = htmlspecialchars(strip_tags($_POST['new_album_name']));
					$log->debug("Upload image","\$new_album_name",$new_album_name);
					
					// Get album id by album name to make sure that album name does not already exist
					include_once(DOCUMENT_ROOT . '/photo/sf/get_album_id.php');
					$album_id = get_album_id($user_id, $new_album_name, $dbc);
					
					// if album id cannot be found a database create a new album
					if (!$album_id) { 
						// Create new album in database
						include_once(DOCUMENT_ROOT . '/photo/sf/create_new_album_in_db.php');
						$album_id = create_new_album_in_db($user_id, $new_album_name);	
						
						// Create new folders for the image
						include_once(DOCUMENT_ROOT . '/photo/sf/create_new_image_folder');
						create_new_image_folder($user_id, $album_id);
					}
				} else {
					// can implement handler here
				}
				
				// create new image entry in database
				include_once(DOCUMENT_ROOT . '/photo/sf/create_new_image_in_db.php');
				$new_image_id = create_new_image_in_db($user_id, $album_id, $new_image_name);
				
				//Move new image to upload folder
				$new_image_path = IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id. "/u_" .  $new_image_name;
				$log->debug("Create image path", "\$new_image_path", $new_image_path);
				move_uploaded_file($temp_file_name, $new_image_path);	
				
				// Add resized image to upload folder
				include_once(DOCUMENT_ROOT . '/photo/sf/add_new_image_file.php');
				add_new_image_file($user_id, $album_id, $new_image_name, $new_image_path);

				// Set default album cover 
				if (!$album_exist) { // if the album does not exist in database	
					include_once(DOCUMENT_ROOT . '/photo/sf/set_album_cover.php');
					set_album_cover($new_image_id, $album_id);
				}
				
				mysqli_close($dbc);
				
				$image_uploaded = true;
				//imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 	

				
				
				//imagejpeg($tn, $thumbnail, 100) ;
				
				// Redirect Back to Previous page
				$caid = $album_id;
				header( 'Location: ../photo/upload.php?album=' . $album_id . "&image=" . $pid );
			}
		}
	}
}

// Get album
$existing_album_id;
if (isset($_GET['album'])){
	$existing_album_id =	$_GET['album'];
	$log->debug("Upload photo", "\$caid", $existing_album_id);
} elseif(isset($_GET['new_album_name'])){
	$new_album_name = $_GET['new_album_name'];
	$log->debug("Upload photo", "\$new_album_name", $new_album_name);
}



?>
<div id="content">
    <div id="display">  <!-- Display -->
        <form action="../photo/upload.php" method="post" enctype="multipart/form-data" id="something" class="uniForm">
                
				<?php 
					if ($image_uploaded) {
						echo "<h3>Image uploaded. Would you like to upload more to the same album?</h3>";
						$image_uploaded = false;
					}	else {
						echo "<h3>Please select a photo file.</h3>";						
					}
				?>
                
				<input type="file" name="new_image" id="new_image" class="button" size="30" class="fileUpload" />
				<br/>
				<br/>
                
                <input type="hidden" name="new_album_name" value="<?php if(!empty($new_album_name)) echo $new_album_name; ?>">
                <input type="hidden" name="existing_album_id" value="<?php if(!empty($existing_album_id)) echo $existing_album_id; ?>">
	
                <button id="upload" name="submit" type="submit" class="submitButton button"><?php echo $words['upload_images'];?></button>
				
				<br/>
				<br/>
				<input type="button" class="button" name="cancel" value="Cancel" /></a>
        </form>
    </div> <!-- End of display -->
</div>

<?php // Display log
if (!LIVE) {
	$log->display();
} 
?>

<script type="txt/javascript">$.getScript("../photo/js/upload.js");</script>
<?php // Include the HTML footer file:
 // Include the HTML footer file:

if (!isset($_GET['tp']) && !isset($_POST['tp'])) {
	include('../includes/footer.inc.html');

} else
	ob_end_flush();
?>