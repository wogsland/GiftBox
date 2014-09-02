<?php
include 'config.php';
if ($google_app_engine) {
	$mysqli = new mysqli(null, $user, $password, $database, null, '/cloudsql/stone-timing-557:test');
} else {
	$mysqli = new mysqli('p:'.$server, $user, $password, $database);
}
if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>