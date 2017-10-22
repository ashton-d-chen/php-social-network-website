<?php
// index.php
// This is the main page for the site.

// Configuration File

// Include the configuration file:
// require_once ('../includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'home';

if (! isset ( $_GET ['tp'] )) {
	include ('../includes/header.inc.html');
} else
	include ('../includes/ini.inc.php');
	
	// Loggin
	// $log->add("Welcome Page", "\$words['welcome']", $words['welcome']);
	
// Welcome the user (by name if they are logged in):
echo '<div id="content"><h1>' . $words ['welcome'];
if (isset ( $_SESSION ['first_name'] )) {
	echo ", {$_SESSION['first_name']}!";
}
echo '</h1>';

?>

<div id="home_content">
	<p>Welcome to Aquasque. This photo sharing website was built to
		demonstrate serveral key web design techniques.</p>

	<ul>
		<li>Aquasque can be viewed by browsers with or without Javascript
			enable.</li>

		<li>The navigation bar displays animated drop-down menu using
			Javascript.</li>

		<li>Users can choose their preferred languages. Available languages
			are English, Japanese, and Chinese.</li>

		<li>In addition, users can register and login to their account to
			create their own profile, upload photos, and participate in forum
			discussions.</li>

		<li>Fade in and fade out effect on page or content load.</li>

		<li>On the photo page, Ajax is used to retrieve data from server in
			order to minimize bandwidth usage.</li>

		<li>Users can use email guest@aquasque.com and password test to login
			to test the website's functions.</li>
	</ul>


</div>
</div>

<?php
if (! isset ( $_GET ['tp'] ))
	include ('../includes/footer.inc.html');
else
	ob_end_flush ();
?>