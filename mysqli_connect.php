<?php // mysqli_connect.php
DEFINE('DB_USER', 'admin'); // root
DEFINE('DB_PASSWORD', 'admin123'); // no password
DEFINE('DB_NAME', 'onlineshop');
// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,
DB_NAME) OR die('Could not connect to MySQL:
'.mysqli_connect_error());
?>