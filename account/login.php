<?php # login.php
// This is the login page for the site.
$page_title = 'login';
// Configuration File
if (!isset($_GET['tp']) && !isset($_POST['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');

if (isset($_POST['submitted'])) {
	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<p class="error">You forgot to enter your email address!</p>';
	}
	
	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
	} else {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}
	
	if ($e && $p) { // If everything is OK.
		
		// Query the database:
		$q = "SELECT user_id, first_name, user_level FROM users WHERE (email='$e' AND pass=SHA1('$p')) AND active IS NULL";		
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
		if (@mysqli_num_rows($r) == 1) { // A match was made.

			
			// Register the values & redirect:
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC); 
			
			//mysqli_free_result($r);
			//mysqli_close($dbc);
							
			//$url = BASE_URL . 'home/index.php'; // Define the URL:			//ob_end_clean(); // Delete the buffer.
			
			
			header('Location: ' . BASE_URL . '/home/index.php');
			// return loginout button
			echo '<a href="#" id="loginout" title="';
			  if (isset($_SESSION['user_id'])) {echo $words['logout'];} else {echo $words['login'];}
			 
			 echo '">';
			  if (isset($_SESSION['user_id'])) {echo $words['logout'];} else {echo $words['login'];}
			  echo '</a>';
		
			//exit(); // Quit the script.
				
		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}
		
	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}
	
	//mysqli_close($dbc);

} else {// End of SUBMIT conditional.


	echo '<div id="content"><h1>' . $words['login'] . '</h1>
	<p>Your browser must allow cookies in order to log in.</p>
	<form id="login_form" action="../account/login.php" method="post" accept-charset="UTF-8">
		<fieldset>
		<p><b>' . $words['email'] . '</b> <input type="text" id="email" name="email" size="40" maxlength="40" value="guest@aquasque.com"/></p>
		<p><b>' . $words['password'] . ' </b> <input type="password" id="pass" name="pass" size="40" maxlength="20" value="test"/></p>
		<div align="center"><input id="li_submit" class="button" type="submit" name="submit" value="Login" /></div>
		<input type="hidden" name="submitted" value="TRUE" />
	
		</fieldset>
	</form>';
	 // Include the HTML footer.
	echo '<a href="../account/forgot_password.php" title="Password Retrieval">' . $words['forgot_password'] . '</a>';
	echo '<span>      </span>';
	echo '<a id="register" href="../account/register.php" title="Register for the Site">'. $words['register'] . '</a>';
	
	
	echo '</div>'; // End of content
	

}

echo '<script type="text/javascript">$.getScript("../account/js/register.js");</script>';

if (!isset($_GET['tp']) && !isset($_POST['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();

?>
