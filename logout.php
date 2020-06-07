<?php

session_start();
if ( isset($_SESSION['status']) ) {
	$status = htmlentities($_SESSION['status']);
	$status_color = htmlentities($_SESSION['color']);

	unset($_SESSION['status']);
	unset($_SESSION['color']);
}

$na = htmlentities($_SESSION['na']);
$_SESSION['color'] = 'red';
unset($_SESSION['email']);
unset($_SESSION['pass']);
header('Location:index.php');
session_destroy();
?>