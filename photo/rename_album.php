<?php # Rename Album

$page_title = 'rename_album';
// Configuration File
if (!isset($_GET['tp']) && !isset($_POST['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');

echo '<div id="content">';	
if(isset($_POST['submit'])){
	if(isset($_SESSION['user_id']) && isset($_POST['album_id'])) {	
			
		// Check album name
		$new_album_name;
		if (empty($_POST['new_album_name'])) {	// if user does not enter album name
			echo '<p>Please enter an album name for this post.</p>';
		} else {
			$new_album_name = htmlspecialchars(strip_tags($_POST['new_album_name']));
			
			// Update Album Name
			$q = "UPDATE albums SET album_name = '$new_album_name' WHERE album_id = '{$_POST['album_id']}' LIMIT 1";
			@mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			// Redirect Back to Original Page
			mysqli_close($dbc);

			header( 'Location: ' . BASE_URL . '/photo/index.php?album=' . $_POST['album_id'] );
		}
	}
}
		

echo '<div id="content">';?>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" enctype="multipart/form-data" id="something" class="uniForm">
		<br />
		<h3>Please specify a new album name.</h3>
		<input name="new_album_name" type="text" size="60" maxlength="100" value="" /><br /><br />
		<input name="album_id" type="hidden" value="<?php echo $_GET['album'];?>" /><br /><br />
		<button name="submit" type="submit" class="submitButton">Rename Current Album</button>
        <?php echo '<input id="cancel_button" type="button" class="button" name="cancel" value="Cancel" /></a>'; ?>
</form>
</div>


<?php 
echo '</div>';
 // Include the HTML footer file:
 if (!isset($_GET['tp'])) 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();

?>