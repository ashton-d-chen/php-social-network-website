<?php

// Upload file
function add_new_image_file($user_id, $album_id, $new_image_name, $new_image_path) {

	
	include_once(DOCUMENT_ROOT . '/photo/sf/find_file_extension.php');
	$ext = findexts($new_image_name);	// get upload file's extension

	list($width, $height) = getimagesize($new_image_path) ; 
			
	// save webview
			
			
	$modheight = 300;	// Resize height first
	$modwidth = $modheight * $width / $height;	// Resize width
			
	if ($modwidth > 750) {
		$modwidth = 750;
		$modheight = $modwidth * $height / $width;
	}
	/*	
	if ($width > $height) {
		$modwidth = 500;
		$modheight = $modwidth * $height / $width;
	} else {
		$modheight = 300;
		$modwidth = $modheight * $width / $height;	
	}
	*/
	echo "mod height = " . $modheight;
	echo "mod width = " . $modwidth;
		
	
	$tn = imagecreatetruecolor($modwidth, $modheight) ; 
	$image = imagecreatefromjpeg($new_image_path) ; 
	imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
	$webview = IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id . "/w_" . $new_image_name; //This is the new file you saving
	imagejpeg($tn, $webview, 100) ; 


	// save thumbnails
	$modheight = 40;	// specify the height of resized image
	$diff1 = $height / $modheight;
	$diff2 = $width / $modheight;
	
	if ($diff1 > $diff2) { // determine which side is smaller
		$modside = $width / $diff2;
	} else {
		$modside = $width / $diff1;
	}
			
	//$tn = imagecreatetruecolor($modwidth, $modheight) ; 
	$image = imagecreatefromjpeg($new_image_path) ; 
	$dpath = IMAGE_UPLOAD_PATH . "/" . $user_id . "/" . $album_id. "/t_" . $new_image_name; //This is the new file you saving				
	include_once(DOCUMENT_ROOT . '/photo/sf/resize_image.php');
	resize_image($image,$dpath,75,TRUE); 
}

?>