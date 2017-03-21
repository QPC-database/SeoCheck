<?php
$servername = "localhost";
$username = "username";
$password = "password";
$db = "SeoCheck";

//Open a new connection to the MySQL server
$mysqli = new mysqli($servername, $username, $password, $db);
//Output any connection error
if ($mysqli->connect_error) {
	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>
