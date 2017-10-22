<?php //Select an album for upload image


$page_title = 'select_albume_for_upload';
// Configuration File
if (!isset($_GET['tp']) && !isset($_POST['tp'])) {
	include('../includes/header.inc.html');

} else {
	include('../includes/ini.inc.php');
}

$log->info("Select an album for loading image");
?>


<div id="content">
		
		<?php
			include(DOCUMENT_ROOT . '/photo/sf/determine_album_id.php');
			if (determine_album_id()){
				echo '<h3>Please select an album to upload your image</h3>';

				// Display album preview
				$log->info("Include album preview script");
				$album_preview_destinaiton = "../photo/upload.php";
				include('sf/album_preview.php');
				display_album_preview($uid, $caid, $album_preview_destinaiton);

						
				echo ' 
				<br/>
				<br/>
				<h3>Or</h3>
				<br/>
		
				<h4>Create a new one.</h4>';
	
			} else {
				echo '<h3>Please create a new album.</h3>';
			}
		?>
		
		<form method="get" action="../photo/upload.php">
			<input name="new_album_name" type="text" size="60" maxlength="100" value="" /> 
			<input id="create_button" type="submit" class="button" value="Create New Album" />
		</form>
		<br />
		<br />
		<br/>
		<br/>

		
		<!--<input id="ok_button" type="button" class="button" name="ok" value="OK">-->
		<form method="get" action="../photo/index.php">
			<input id="cancel_button" type="button" class="button" name="cancel" value="Cancel">
		</form>
</div>

<?php
	if (!LIVE){
		$log->display();
	}
?>

<script type="txt/javascript">

//$.getScript("../photo/js/upload.js");

$("#album_preview_list a").attr("href", "#");
$("#album_preview_list").off("click", "a");
$("#album_preview_list").on("click", "a", function(){
	alert($(this).attr("alt"));
});

</script>
<?php // Include the HTML footer file:
 // Include the HTML footer file:

if (!isset($_GET['tp']) && !isset($_POST['tp'])) {
	include('../includes/footer.inc.html');

} else
	ob_end_flush();
?>