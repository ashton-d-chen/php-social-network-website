<?php
// config.inc.php
/*
 * This script:
 * - define constants and settings
 * - dictates how errors are handled
 * - defines useful functions
 */

// Document who created this site, when, why, etc.

// ********************************** //
// ************ CONSTANT SETTINGS ************ //

// Flag variable for site status:
define ( 'LIVE', FALSE );

// Admin contact address:
define ( 'EMAIL', 'InsertRealAddressHere' );

// Relative Path
define ('RELATIVE_PATH', '/phpweb');

// Site URL (base for all redirections):
define ('BASE_URL', '//' .$_SERVER['SERVER_NAME'] . RELATIVE_PATH);

// Document root
define ('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"] . RELATIVE_PATH);

// Location of the MySQL connection script:
define ( 'MYSQL', DOCUMENT_ROOT . '/mysqli_connect.php' );

// Header
define ( 'HEADER', DOCUMENT_ROOT . '/includes/header.inc.html' );

// Footer
define ( 'FOOTER', DOCUMENT_ROOT . '/includes/footer.inc.html' );

// Default admin user ID number
define ( 'DEFAULT_ADMIN_ID', 1 );

// Default guest user ID number
define ( 'DEFAULT_GUEST_ID', 2 );

// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set ( 'US/Eastern' );

// Fading out and in configuration
define ( 'FADEOUTSPEED', 700 );

define ( 'FADEINSPEED', 700 );

define ( 'FADEOUTDELAY', 400 );

define ( 'FADEINDELAY', 400 );

// Where images are stored
define ( 'IMAGE_UPLOAD_URL', BASE_URL . '/media/images' );

// Where images will be uploaded to
define ( 'IMAGE_UPLOAD_PATH', DOCUMENT_ROOT . "/media/images" );

// Where sameple images are stored
define ( 'DEFAULT_IMAGE_PATH', DOCUMENT_ROOT . "/media/sample_images" );

// ************ VARIABLE SETTINGS ************ //
// ********************************** //

// Server path
$workpath = DOCUMENT_ROOT;

// Image file upload path
// $uploadpath = $workpath . "/photo/uploads" ; // upload destination

// number of file in upload directory
$uploadNum = 0;

// ****************************************** //
// ************ ERROR MANAGEMENT ************ //

// Create the error handler:
/*
 * function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
 *
 * // Build the error message.
 * $message = "<p>An error occurred in script '$e_file' on line $e_line: $e_message\n<br />";
 *
 * // Add the date and time:
 * $message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
 *
 * // Append $e_vars to the $message:
 * $message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n</p>";
 *
 * if (!LIVE) { // Development (print the error).
 *
 * echo '<div class="error">' . $message . '</div><br />';
 *
 * } else { // Don't show the error:
 *
 * // Send an email to the admin:
 * mail(EMAIL, 'Site Error!', $message, 'From: email@example.com');
 *
 * // Only print an error message if the error isn't a notice:
 * if ($e_number != E_NOTICE) {
 * echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
 * }
 * } // End of !LIVE IF.
 *
 * } // End of my_error_handler() definition.
 */
// Use my error handler.
// set_error_handler ('my_error_handler');

// ************ ERROR MANAGEMENT ************ //
// ****************************************** //

// ****************************************** //
// ************ LOGGER ************ //
class Log {
	private $logs = array ();
	function debug($context, $variable, $value) {
		array_push ( $this->logs, "<b>" . $context . "</b>: " . $variable . " = " . $value );
	}
	function info($message) {
		array_push ( $this->logs, $message );
	}
	function display() {
		echo '<div style = "color:green; text-align:left;"><b>Log</b><ol>';
		foreach ( $this->logs as $log ) {
			echo "<li>" . $log . "</li>";
		}
		echo "</ol>";
	}
}
$log = new LOG ();
// ************ LOGGER ************ //
// ****************************************** //

?>