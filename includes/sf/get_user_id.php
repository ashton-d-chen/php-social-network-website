<?php

function get_user_id(){
	
	global $uid;
	if(isset($_SESSION['user_id'])){ // if user is logged in, display user's album
		$uid = $_SESSION['user_id'];
	} else {  // if no user login, consider as default user
		$uid = DEFAULT_ADMIN_ID;
	}
}
?>
