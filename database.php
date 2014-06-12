<?php
include 'config.php';
if ($_SERVER['SERVER_NAME'] == "giftbox.com") {
	$mysqli = new mysqli('p:'.$server, $user, $password, $database);
} else {
	$mysqli = new mysqli(null, $user, $password, $database, null, '/cloudsql/stone-timing-557:test');
}
if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>