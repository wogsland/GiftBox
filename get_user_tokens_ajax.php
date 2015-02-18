<?php
include_once 'util.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	$sql = "SELECT id, name from giftbox where user_id = ".$_SESSION['user_id']." ORDER BY name";
	$results = execute_query($sql);
	$response = $results->fetch_all(MYSQLI_ASSOC);

	header('Content-Type: application/json');
	echo json_encode($response);
}