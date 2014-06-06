<?php
include 'config.php';
$mysqli = new mysqli('p:'.$server, $user, $password, $database);
if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>