<?php
/* Displays user information and some useful messages */
require 'db.php';
session_start();

if (isset($_SESSION['logged_in'])) {
	if ( $_SESSION['logged_in'] != 1 ) {
		echo 'no';
	}
	else {
		echo 'yes';
	}
}
else {
	$_SESSION['logged_in'] = 0;
	echo 'no';
}
// Check if user is logged in using the session variable
?>