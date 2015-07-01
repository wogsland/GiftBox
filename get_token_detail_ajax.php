<?php
include_once 'util.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	if (isset($_GET['id'])) {
		$sql = "SELECT * FROM giftbox where user_id = ".$_SESSION['user_id']." and id = ".$_GET['id'];
		$results = execute_query($sql);
		$response = $results->fetch_all(MYSQLI_ASSOC);

		header('Content-Type: application/json');
		echo json_encode($response);
	}
}