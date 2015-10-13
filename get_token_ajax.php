<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

include_once 'config.php';
_session_start();

if (isset($_SESSION['user_id'])) {
	if (isset($_GET['id'])) {
		$sql = "SELECT * FROM giftbox where user_id = ".$_SESSION['user_id']." and id = ".$_GET['id'];
		$response = execute_query($sql)->fetch_object();
		$response->app_url = $_SESSION['app_url'];

		$response->bentos = array();
		$sql = "SELECT * FROM bento WHERE giftbox_id = ".$_GET['id']." ORDER BY CAST(css_left AS SIGNED), CAST(css_top AS SIGNED)";
		$results = execute_query($sql);
		while ($bento = $results->fetch_object()) {
			if ($google_app_engine) {
				$bento->image_file_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento->image_file_name, $use_https);
				$bento->download_file_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento->download_file_name, $use_https);
			} else {
				$bento->image_file_path = $file_storage_path.$bento->image_file_name;
				$bento->download_file_path = $file_storage_path.$bento->download_file_name;
			}
			$response->bentos[count($response->bentos)] = $bento;
		}

		$response->dividers = array();
		$sql = "SELECT * FROM divider WHERE giftbox_id = {$_GET['id']}";
		$results = execute_query($sql);
		while ($divider = $results->fetch_object()) {
			$response->dividers[count($response->dividers)] = $divider;
		}

		$sql = "SELECT * FROM attachment WHERE giftbox_id = {$_GET['id']} GROUP BY download_file_name";
		$results = execute_query($sql);
		while ($attachment = $results->fetch_object()) {
			$response->attachments[count($response->attachments)] = $attachment;
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}
}
