<?php

function side_menu_entry($id, $href, $title, $word){
	global $caid, $cpid, $words;
	echo '<li>';
	echo '<a id="' . $id . '" href="' . $href . '?tp=234234123';
		if (isset($caid)){
			echo '&amp;album=' . $caid;
		}
		
		if (isset($cpid)){
			echo '&amp;image=' . $cpid;
		}
		
		echo '" title="' . $title . '">' . $words[$word] . '</a>';
	echo '</li>';
}


echo '<div id="photo_menu" class="menu"><ul>';

	side_menu_entry("select_album_for_upload", "../photo/select_album_for_upload.php", "Upload Images", 'upload_images');
	
	if (isset($caid)) {
		side_menu_entry("rename_album", "../photo/rename_album.php", "Rename Album", 'rename_album');

		side_menu_entry("set_profile_photo", "../photo/profile_photo.php", "Set Profile Photo", 'set_profile_photo');

		side_menu_entry("set_album_cover", "../photo/album_cover.php", "Set Album Cover", 'set_album_cover');	

		side_menu_entry("edit_photo_description", BASE_URL . "/photo/photo_description.php", "Edit Photo Description", 'edit_photo_description');

		side_menu_entry("randomize_photo", "../photo/randomize_image_order.php", "Randomize Photo", 'randomize_photo_order');
		
		side_menu_entry("delete_photo", BASE_URL . "/photo/delete_photo.php", "Delete Photo", 'delete_photo');

		side_menu_entry("delete_album", "../photo/delete_album.php", "Delete Album", 'delete_album');
	}
echo '</ul></div>';
?>