<?php # Profile
$title = 'profile';



if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');
	
// Variables
$uid; // User ID
$ufn; // USer First Name
$uln; // User Last Name

$ubd; // User Birthday Date
$ubm; // User Birthday Month
$uby; // User Birthday Year

$ued; // User Education
$uwk; // User Work Experience

$uit; // User Self Introduction

$uws; // User Website
$ucp; // User Cellphone
$uhp; // User Home Phone
$uem; // USer Email

function profile_info_entry($label, $info){
	
	echo '<div class="entry"><span class="label">' . $label . ': </span><span class="info">' . $info . '</span></div><br />';

}



echo '<div id="content">';
// if user is logged in, display user's profile
if(isset($_SESSION['user_id'])){
	$uid = $_SESSION['user_id'];
	echo '<div id="profile_menu" class="menu"><ul>';
	echo '<li><a href="../profile/edit.php" title="' . $words['edit'] . '">' . $words['edit'] . '</a></li>';
	echo '</ul></div>';
} else {  // else display default user's profile
	$uid = 1;
}

// Start of display
echo '<div id="display">';

// Display user profile photo
$q = "SELECT file_name, album_id FROM images WHERE user_id = $uid AND profile = 1";
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // If user set a profile photo
	$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	$p1 = '../photo/uploads/' . $uid . '/' . $a['album_id'] . '/w_' . $a['file_name'];
	$p2 = '../photo/uploads/' . $uid . '/' . $a['album_id'] . '/t_' . $a['file_name'];
	echo '<div id="profile_photo"><a href="' . $p1 . '"><img src="' . $p2 . '" alt="Profile photo"/></a></div>'; 
}

// Get User Info
$q = "SELECT first_name, last_name, b_date, b_month, b_year, education, work, self_intro, website, h_phone, c_phone, email FROM users WHERE user_id = $uid";
$r = @mysqli_query ($dbc, $q);
$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);


echo '<div id="profile_info">';


echo '<div id="basic_info" class="title">Basic Info</div>';

// Display User Name
if (($a['first_name'] != "") && ($a['last_name'] != "")){
	echo profile_info_entry($words['name'], $a['first_name'] . " " . $a['last_name']);
}

// Display Birthday
if (($a['b_year'] != "") && ($a['b_month'] != "") && ($a['b_date'] != "")) {
	echo profile_info_entry($words['birthday'], $a['b_year'] . "/" . $a['b_month'] . "/" . $a['b_date']);
}



echo '<div id="contact_info" class="title">Contact Info</div>';

// Display Home Phone
if ($a['h_phone'] != 0) {
	echo profile_info_entry($words['h_phone'], $a['h_phone']);
}

// Display Cell Phone
if ($a['c_phone'] != 0) {
	echo profile_info_entry($words['c_phone'], $a['c_phone']);
}


// Display Email
if ($a['email'] != "") {
	echo profile_info_entry($words['email'], $a['email']);
}


echo '<div id="experience_info" class="title">Experience</div>';


// Display Education
if ($a['education'] != "") {
	echo profile_info_entry($words['education'], $a['education']);
}
// Display Work Info
if ($a['work'] != "") {
	echo profile_info_entry($words['work'], $a['work']);
}


echo '<div id="link_info" class="title">Link</div>';

// Display Website
if ($a['website'] != "") {
	echo profile_info_entry($words['website'],  $a['website']);
}

echo '<div id="other_info" class="title">Other</div>';


// Display Self Introduction
if ($a['self_intro'] != "") {
	echo profile_info_entry($words['self_intro'], $a['self_intro']);
	
}

echo '</div>'; // End of Profile info

// End of display
echo '</div></div>';

echo '<script type="text/javascript">$.getScript("../profile/js/profile.js");</script>';
 // Include the HTML footer file:
 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>
