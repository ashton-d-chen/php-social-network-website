<?php # register.php
// This is the registration page for the site.

// Configuration File
require_once ('../includes/config.inc.php'); 

$page_title = 'register';
// This page shows the threads in a forum.
if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');

if (isset($_POST['submitted'])) { // Handle the form.

	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);
	
	// Assume invalid values:
	$un = $fn = $ln = $e = $p = FALSE;
	
	// check for a user name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['user_name'])) {
		$un = mysqli_real_escape_string ($dbc, $trimmed['user_name']);
	} else {
		echo '<p class="error">Please enter your user name!</p>';
	}
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}
	
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	if ($un && $fn && $ln && $e && $p) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0) { // Available.
		
			// Create the activation code:
			$a = md5(uniqid(rand(), true));
		
			// Add the user to the database:
			$q = "INSERT INTO users (user_name, email, pass, first_name, last_name, active, rgt_date) VALUES ('$un', '$e', SHA1('$p'), '$fn', '$ln', '$a', NOW() )";
			$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Send the email:
				$body = "Thank you for registering at Aquasque. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');
				
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		} else { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	} else { // If one of the data tests failed.
		echo '<p class="error">Please re-enter your passwords and try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>
<div id="content">
    <h1><?php echo $words['register']; ?></h1>
    <form action="register.php" method="post">
        <fieldset>
        
        <p><b><?php echo $words['username']; ?>:</b> <input class="input" type="text" name="user_name" size="20" maxlength="20" value="<?php if (isset($trimmed['user_name'])) echo $trimmed['user_name']; ?>" title="Please enter your username."/></p>
        
        <p><b><?php echo $words['first_name']; ?>:</b> <input class="input" type="text" name="first_name" size="20" maxlength="20" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" title="Please enter your first name."/></p>
        
        <p><b><?php echo $words['last_name']; ?>:</b> <input class="input" type="text" name="last_name" size="20" maxlength="40" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" title="Please enter your last name."/></p>
        
        <p><b><?php echo $words['email']; ?>:</b> <input class="input" type="text" name="email" size="30" maxlength="80" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" title="Please enter a valid email address."/> </p>
            
        <p><b><?php echo $words['password']; ?>:</b> <input class="input" type="password" name="password1" size="20" maxlength="20" title="Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long."/> </p>
        
        <p><b><?php echo $words['confirm_password']; ?>:</b> <input class="input" type="password" name="password2" size="20" maxlength="20" title="Passwords must match."/></p>
        </fieldset>
        
        <div align="center"><input type="submit" name="submit" value="<?php echo $words['register'];?>" /></div>
        <input type="hidden" name="submitted" value="TRUE" />
    
    </form>
</div>


<!-- Tooltip -->
<link rel="stylesheet" type="text/css" href="../library/tooltip/ftp.css"/>
<script type="text/javascript">$.getScript("../library/tooltip/tools.js");</script>
<script type="text/javascript">$.getScript("../library/tooltip/ftp.js");</script>

<?php // Include the HTML footer.
 // Include the HTML footer file:

if (!isset($_GET['tp']) && !isset($_POST['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>
