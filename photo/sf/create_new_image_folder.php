<?php
// Create new directory structure for new uploaded image
function create_new_image_folder($user_id, $album_id){
	global $log;
	$log->info("Create new image folder");
	
	//echo '<Script>alert(' . $_SERVER['DOCUMENT_ROOT'] . '</Script>';
	//echo mkdir($upload_path . "/" . $user_id);

	//echo file_exists ($upload_path);
	
	// Create upload path directory if not exist
	if (!file_exists (IMAGE_UPLOAD_PATH)) {
		$log->info('Upload directory does not exist, create one as \"' . IMAGE_UPLOAD_PATH . '\"');
		// Change permission
		$old = umask(0);
		mkdir(IMAGE_UPLOAD_PATH, 0777, true);
		umask($old);
	}
	
	// if user does not have a photo directory, create one.
	if(!file_exists(IMAGE_UPLOAD_PATH . "/" . $user_id)) {
		$log->info('User\'s upload directory does not exist, create one as \"' . IMAGE_UPLOAD_PATH . "/" . $user_id . '\"');
		mkdir(IMAGE_UPLOAD_PATH . "/" . $user_id) or die ("Could not make directory");
	}
	
	// if album directory does not exist on the server, create one.
	if(!file_exists(IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id)) {
		$log->info('User\'s upload album directory does not exist, create one as \"' . IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id . '\"');
		mkdir(IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id) or die ("Could not make directory");
	}
}	
?>