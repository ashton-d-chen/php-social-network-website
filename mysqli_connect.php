<?php # Script 15.x - mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.

// Set the database access information as constants:
DEFINE ('DB_USER', 'ascveo_php');
DEFINE ('DB_PASSWORD', '&U},OMzh}eZxyB_?rI');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'ascveo_php');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
// mysql_select_db(DB_NAME, $abc);
// Set the encoding...
mysqli_set_charset($dbc, 'utf8');

// Use this next option if your system doesn't support mysqli_set_charset().
//@mysqli_query($dbc, 'SET NAMES utf8');
		


?>