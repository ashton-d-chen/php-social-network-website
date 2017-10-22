<?php # Edit Photo Description
$page_title = 'edit_photo_description';
if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');



echo '<div id="content">';
if(isset($_POST['submit'])){
	if(isset($_SESSION['user_id']) && isset($_GET['image'])) {	
			
		// Check album name
		$image = FALSE;
		if (empty($_POST['image'])) {	// if user does not enter anything
			$image = FALSE;
			echo '<p>Please enter an album name for this post.</p>';
		} else {
			$image = htmlspecialchars(strip_tags($_POST['image']));
		}
		
		// Update Album Name
		$q = "UPDATE images SET description = '" . $image . "' WHERE user_id = '{$_SESSION['user_id']}' AND image_id = '{$_GET['image']}' LIMIT 1";
		@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		// Redirect Back to Original Page

		header( 'Location: ' . BASE_URL . '/photo/index.php?amp;album=' . $_GET['album'] . "&amp;image=" . $_GET['image'] );
		exit;
	}
}
		
?>

<form action="../photo/photo_description.php<?php echo "?album=" . $_GET['album'] . "&image=" . $_GET['image'];?>" method="post" enctype="multipart/form-data" id="something" class="uniForm">
        
		<p>Please specify a new photo description.</p>
		<input name="image" type="text" size="60" maxlength="100" value="" /><br /><br />
		
		<button name="submit" type="submit" class="submitButton">Change Photo Description</button>
        <input id="cancel_button" type="button" class="button" name="cancel" value="Cancel" />
        <?php //echo '<a href="../photo/index.php?album=' . $_GET['album'] . "&image=" . $_GET['image'] . '"><input id="cancel_button" type="button" class="button" name="cancel" value="Cancel" /></a>'; ?>
</form>

<?php // Include the HTML footer file:
echo '</div>';
 // Include the HTML footer file:
 if (!isset($_GET['tp'])) 
	 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();
?>