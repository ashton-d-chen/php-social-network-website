<?php
$page_title = 'Reset';
if (!isset($_GET['tp']))
	include_once('../includes/header.inc.html');
else
	include_once('../includes/ini.inc.php');

function update_user_database_info(){
	global $pass, $lang_id, $user_level, $user_name, $first_name, $last_name, $email, $self_intro, $b_date, $b_month, $b_year, $education, $work, $website, $c_phone, $h_phone;
	
	if(!isset($pass))
		$pass = "test";
	if(!isset($lang_id))
		$lang_id = 1;
	if(!isset($user_level))
		$user_level = 5;
	if(!isset($user_name))
		$user_name = "guest";
	if(!isset($first_name))
		$first_name = "Jack";
	if(!isset($last_name))
		$last_name = "Ryan";
	if(!isset($email))
		$email = "guest@aquasque.com";
	if(!isset($self_intro))
		$self_intro = "Hello everyone!";
	if(!isset($b_date))
		$b_date = 17;
	if(!isset($b_month))
		$b_month = 8;
	if(!isset($b_year))
		$b_year = 1990;
	if(!isset($education))
		$education = "University of Vancouver";
	if(!isset($work))
		$work = "Some Company";
	if(!isset($website))
		$website = "http://www.google.com";
	if(!isset($c_phone))
		$c_phone = "6041111111";
	if(!isset($h_phone))
		$h_phone = "6048888888";
	
$q = "UPDATE users SET pass=SHA1('$pass') lang_id = '$lang_id', user_level='$user_level', user_name = '$user_name', first_name = '$first_name', last_name = '$last_name', email='$email', self_intro='$self_intro', b_date='$b_date', b_month='$b_month',b_year='$b_year', education='$education', work='$work', website='$website', c_phone='$c_phone', h_phone='$h_phone' WHERE user_id = " . DEFAULT_ADMIN_ID;
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

}

function initialize_gallery($user_id) {
	global $log;
	
	for($i=0; $i < 5; $i++){
		$new_album_name = "Album " . $i;
		
		// Create new album in database
		include_once(DOCUMENT_ROOT . '/photo/sf/create_new_album_in_db.php');
		$album_id = create_new_album_in_db($user_id, $new_album_name);	

		// Create new folders for the image
		include_once(DOCUMENT_ROOT . '/photo/sf/create_new_image_folder.php');
		create_new_image_folder($user_id, $album_id);
		
		$new_iamge_id;
		$selected_images = array();
		for($j=0; $j < 10; $j++){
			include_once(DOCUMENT_ROOT . '/photo/sf/select_random_file.php');
			$new_image_file = select_random_file();
			while(in_array($new_image_file,$selected_images)){
				$new_image_file = select_random_file();				
			}
			array_push($selected_images, $new_image_file);
			$new_image_name = basename($new_image_file);
			
			// create new image entry in database
			include_once(DOCUMENT_ROOT . '/photo/sf/create_new_image_in_db.php');
			$new_image_id = create_new_image_in_db($user_id, $album_id, $new_image_name);

			//Upload image file
			$new_image_path = IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id. "/u_" .  $new_image_name;
			copy($new_image_file, IMAGE_UPLOAD_PATH . '/' . $user_id . '/' . $album_id . '/u_' . $new_image_name);
			include_once(DOCUMENT_ROOT . '/photo/sf/add_new_image_file.php');
			add_new_image_file($user_id, $album_id, $new_image_name, $new_image_path);
		}
		
		// Set default album cover 
		include_once(DOCUMENT_ROOT . '/photo/sf/set_album_cover.php');
		set_album_cover($new_image_id, $album_id);
		
	}
}

function delete_directory($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delete_directory("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 


// remove all photos from database
$q = 'DELETE FROM images';
@mysqli_query ($dbc, $q) ;


// Remove files from folders
$a;
$q = 'SELECT user_id FROM users';
$r = @mysqli_query ($dbc, $q);

while($a = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		// remove upload folders and files
		$folder_to_delete = IMAGE_UPLOAD_PATH . '/' . $a['user_id'];
		//system("rm -rf ".escapeshellarg($folder_to_delete));
		if (is_dir($folder_to_delete)) {		
			//include(DOCUMENT_ROOT . '/photo/sf/delete_directory.php');
			delete_directory($folder_to_delete);
		}
		$log->info('Folder under user ID ' . $a['user_id'] .' is removed') ;	
}



//remove all album from database
$q = 'DELETE FROM albums';
@mysqli_query ($dbc, $q) ;


// remove all users except admin and guest
$q = 'DELETE FROM images WHERE user_id IS NOT IN (' . DEFAULT_ADMIN_ID . ',' . DEFAULT_GUEST_ID . ')';
@mysqli_query ($dbc, $q) ;


// If default guest user does not exist, create a new one
$q = 'SELECT user_id FROM users WHERE user_id IS ' . DEFAULT_GUEST_ID . ')';
$r = @mysqli_query ($dbc, $q);
if(!$r){
	$un = "visitor";
	$e = "guest@aquasque.com";
	$p = "test";
	$fn = "Jack";
	$ln = "Ryan";
	$a = NULL;
	
	// Add the user to the database:
	$q = "INSERT INTO users (user_name, email, pass, first_name, last_name, active, rgt_date) VALUES ('$un', '$e', SHA1('$p'), '$fn', '$ln', " . $a . ", NOW() )";
	$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

	if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.{
				$log->info('Guest user created');
				echo "Guest user created";
	}
}

// initial profile 
// admin profile
$pass = "test";
$lang_id = 1;
$user_level = 1;
$user_name = "admin";
$first_name = "Ashton";
$last_name = "Chen";
$email = "admin@aquasque.com";
$self_intro = "Hello everyone!";
$b_date = 12;
$b_month = 5;
$b_year = 1992;
$education = "University of Washington";
$work = "Some Company";
$website = "http://www.ashtonchen.com";
$c_phone = "6040000000";
$h_phone = "6049999999";

update_user_database_info();


// Guest profile 
update_user_database_info();


// recreate gallery
initialize_gallery(DEFAULT_ADMIN_ID);
initialize_gallery(DEFAULT_GUEST_ID);


header('Location: ' . BASE_URL . '/photo/index.php');

// Include the HTML footer file:
if (!isset($_GET['tp'])) 
	 
	include('../includes/footer.inc.html');
else  
	ob_end_flush();
?>