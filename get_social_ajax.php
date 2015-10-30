<?php
include_once 'config.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	$sql = "SELECT id, network, url from social where user_id = ".$_SESSION['user_id']." ORDER BY id";
	$results = execute_query($sql);
	$response = $results->fetch_all(MYSQLI_ASSOC);

	header('Content-Type: application/json');
	echo json_encode($response);
}
