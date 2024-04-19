<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Destroy the session and redirect the user to the login page
session_start();
$_SESSION = array();
session_destroy();
header('Location: login.php');
?>
