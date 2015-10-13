<?php
include_once 'util.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	if (isset($_POST['tokenId']) && (int) $_POST['tokenId'] == $_POST['tokenId']) {
		$sql = "DELETE FROM giftbox WHERE id = '{$_POST['tokenId']}'";
		$results = execute_query($sql);
		// $response = $results->fetch_all(MYSQLI_ASSOC);

		header('Content-Type: application/json');
		// echo json_encode($response);
	}
}
