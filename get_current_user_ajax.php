<?php
include_once 'config.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	$sql = "SELECT id, admin, first_name, last_name, email_address, level, location, company, position, about, username from user where id = ".$_SESSION['user_id']." ORDER BY last_name";
	$results = execute_query($sql);
	$response = $results->fetch_all(MYSQLI_ASSOC);

	header('Content-Type: application/json');
	echo json_encode($response);
}
