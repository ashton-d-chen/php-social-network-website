<?php # Edit Profile Info

// add page title
$page_title = 'edit_profile';

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


if(isset($_POST['submit'])){
	if(isset($_SESSION['user_id'])) {	
		
		// Extract User Info
		$q = "SELECT first_name, last_name, b_date, b_month, b_year, education, work, self_intro, website, h_phone, c_phone, email FROM users WHERE user_id = {$_SESSION['user_id']}";
		$r = @mysqli_query ($dbc, $q);
		$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	
	
		$q = "UPDATE users SET ";
		$c = 0;
		// Check First Name Change
		if ($_POST['first_name'] != $a['first_name']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "first_name='" . $_POST['first_name'] . "'";	
			$c++;
		}
		// Check Last Name Change
		if ($_POST['last_name'] != $a['last_name']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "last_name='" . $_POST['last_name'] ."'";
			$c++;	
		}
		
		// Check Birth Year Change
		if ($_POST['b_year'] != $a['b_year']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "b_year='" . $_POST['b_year'] ."'";
			$c++;	
		}
		
		// Check Birth Month Change
		if ($_POST['b_month'] != $a['b_month']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "b_month='" . $_POST['b_month'] . "'";	
			$c++;
		}
		
		// Chekc Birth Date Chnage
		if ($_POST['b_date'] != $a['b_date']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "b_date='" . $_POST['b_date'] ."'";	
			$c++;
		}
		
		// Check Education Chnage
		if ($_POST['education'] != $a['education']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "education='" . $_POST['education'] ."'";	
			$c++;
		}
		
		// Check Work Chnage
		if ($_POST['work'] != $a['work']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "work='" . $_POST['work'] . "'";	
			$c++;
		}
		
		// Check Website Change
		if ($_POST['website'] != $a['website']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "website='" . $_POST['website'] . "'";	
			$c++;
		}
		
		// Check Home Phont Change
		if (($_POST['h_phone'] != $a['h_phone']) && is_numeric($_POST['h_phone'])) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";		
			$q = $q . "h_phone=" . $_POST['h_phone'] ."";	
			$c++;
		}
		
		// Check Cell Phone Change
		if (($_POST['c_phone'] != $a['c_phone'])  && is_numeric($_POST['c_phone'])) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "c_phone=" . $_POST['c_phone'] . "";	
			$c++;
		}
		
		// Check email Change
		if ($_POST['email'] != $a['email']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "email='" . $_POST['email'] . "'";	
			$c++;
		}
		
		// Check Self Introduction Change
		if ($_POST['self_intro'] != $a['self_intro']) {
			// Insert comma
			if ($c > 0 )
				$q = $q . ", ";
			$q = $q . "self_intro='" . $_POST['self_intro'] . "'";	
			$c++;
		}		
		
		// If user changed something
		if ($c > 0) {
			$q = $q . " WHERE user_id = {$_SESSION['user_id']}";
			$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		}
		
		header( 'Location: ../profile/index.php' );
	}
}





// if user is logged in, display user's profile
if(isset($_SESSION['user_id'])){
	$uid = $_SESSION['user_id'];
} else {  // else display default user's profile
	$uid = 1;
}



// Display content
echo '<div id="content">';	


// Display user profile photo
$q = "SELECT file_name, album_id FROM images WHERE user_id = $uid AND profile = 1";
$r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 1) { // If user set a profile photo
	$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	$p1 = BASE_URL . '/photo/uploads/' . $uid . '/' . $a['album_id'] . '/w_' . $a['file_name'];
	$p2 = BASE_URL . '/photo/uploads/' . $uid . '/' . $a['album_id'] . '/t_' . $a['file_name'];
	echo '<div id="profile_photo"><a href="' . $p1 . '"><img src="' . $p2 . '" alt="Profile photo"/></a></div>'; 
}



// Display Edit Profile Titl
echo '<br/><h3>Edit Profile</h3>';

// Get User Info
$q = "SELECT first_name, last_name, b_date, b_month, b_year, education, work, self_intro, website, h_phone, c_phone, email FROM users WHERE user_id = '$uid'";
$r = @mysqli_query ($dbc, $q);
$a = mysqli_fetch_array ($r, MYSQLI_ASSOC);


// Info Entry
function edit_info_entry($id, $title) {
	global $words, $a;
	echo '<div class="entry"><label for="' . $id . '">' . $words[$id] . ': </label> <input id="' . $id . '" class="input" name="'. $id . '" type="text" size="60" maxlength="100" title="'. $title . '" value="' . $a[$id] . '" /></div>';
}

////////// Input Form //////////
echo '<form id="edit_info" class="uniForm" action="../profile/edit.php" method="post" enctype="multipart/form-data" >';

edit_info_entry("first_name", "Your first name must not contain any numbers.");        

edit_info_entry("last_name", "Your last name must not contain any numbers.");  	
		
		
echo '<div class="entry" ><label for="month">Birthday: </label><div id="birthday">
   <select id="month" name="b_month">';
   
   for ($i=1; $i<=12; $i++) {
	
	echo '<option value="' . $i;
	
	if ($a['b_month'] == $i)
		echo '" selected>';
	else 
		echo '">';
		
		
	if ($i == 1)
		echo "January";
	else if ($i == 2)
		echo "February";
	else if ($i == 3)
		echo "March";
	else if ($i == 4)
		echo "April";
	else if ($i == 5)
		echo "May";
	else if ($i == 6)
		echo "June";
	else if ($i == 7)
		echo "July";
	else if ($i == 8)
		echo "August";
	else if ($i == 9)
		echo "September";
	else if ($i == 10)
		echo "October";
	else if ($i == 11)
		echo "November";
	else if ($i == 12)
		echo "December";
	
	echo '</option>';
   }

echo   '</select>
   <select name="b_date">'; 

    for ($i=1; $i<=31; $i++)
    {
     echo "<option value='$i'";
	
	if ($a['b_date'] == $i)
		echo ' selected';
	 echo ">$i</option>";
    }

echo '</select>
   <select name="b_year">';

    for ($i=gmDate("Y"); $i>=1900; $i=$i-1)
    {
     echo "<option value='$i'";
	 if ($a['b_year'] == $i)
		echo ' selected';	
	 echo ">$i</option>";
    }

echo '</select></div></div>';

edit_info_entry("h_phone", "Please enter your home phone, numbers only.");  	
		
edit_info_entry("c_phone", "Please enter your cell phone, numbers only.");  	

edit_info_entry("email", "Your email address");  	
				
edit_info_entry("education", "Please enter your school.");  	

edit_info_entry("work", "Please enter your previous employment.");  	

edit_info_entry("website", "Your personal website address");  	

		
//echo $words['self_intro'] . '  <input name="self_intro" type="text" size="60" maxlength="100" value="' . $a['self_intro'] . '" /><br /><br />';
  
echo '<div class="entry" id="self_intro"><label for="self_intro_text" >' . $words['self_intro'] . ':  </label><TEXTAREA class="input" id="self_intro_text" name="self_intro" rows="10" cols="50" title="Please tell us about yourself." >' . $a['self_intro'] . '</TEXTAREA></div>';
//echo '<a href="../profile/index.php"><input class="button" type="button" name="cancel" title="Cancel and return to previous page." value="Cancel" /></a></div></form>';
echo '<button name="submit" type="submit" class="button">OK</button></form>';

// End of content
echo '</div>';


?>
    <script type="text/javascript">$.getScript( "../includes/js/tooltip.js");</script>
    <script type="text/javascript">$.getScript(DOCUMENT_ROOT . "/library/tooltip/tools.js");</script>
    <script type="text/javascript">$.getScript(DOCUMENT_ROOT . "/library/tooltip/ftp.js");</script>
<?php
 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
