<?php
include_once 'util.php';
session_start();

if (isset($_SESSION['user_id'])) {
	if (isset($_GET['id'])) {
		$sql = "SELECT * FROM giftbox where user_id = ".$_SESSION['user_id']." and id = ".$_GET['id'];
		$response = execute_query($sql)->fetch_object();
		$response->app_url = $_SESSION['app_url'];
		
		$response->bentos = array();
		$sql = "SELECT * FROM bento WHERE giftbox_id = ".$_GET['id']." ORDER BY CAST(css_left AS SIGNED), CAST(css_top AS SIGNED)";
		$results = execute_query($sql);
		$index = 0;
		while ($bento = $results->fetch_object()) {
			$response->bentos[$index] = $bento;
			$index++;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}