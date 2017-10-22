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
	
	// Welcome the user (by name if they are logged in):
echo '<h1>' . $words ['welcome'];
if (isset ( $_SESSION ['first_name'] )) {
	echo ", {$_SESSION['first_name']}!";
}
echo '</h1>';
?>
<h2>This is the portfolio page</h2>


<?php
if (! isset ( $_GET ['tp'] ))
	include ('../includes/footer.inc.html');
else
	ob_end_flush ();
?>
