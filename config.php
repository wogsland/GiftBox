<?php
$google_app_engine = false;
$server = $_SERVER['SERVER_NAME'];
$prefix = "http://";
$app_root = "/";
$use_https = false;
$socket = null;
if (isset($_SERVER['HTTPS'])) {
	if ($_SERVER['HTTPS'] === "on") {
		$prefix = "https://";
		$use_https = true;
	}
}
if (isset($_SERVER["HTTP_X_APPENGINE_COUNTRY"])) {
	$application_id = $_SERVER["APPLICATION_ID"];
	$google_app_engine = true;
	if ($application_id === "s~stone-timing-557") {
		$file_storage_path = 'gs://tokenstorage/';
		$socket = '/cloudsql/stone-timing-557:test';
	} elseif ($application_id === "s~t-sunlight-757") {
		$file_storage_path = 'gs://tokenstorage-staging/';
		$socket = '/cloudsql/t-sunlight-757:staging';
	} else {
		$file_storage_path = 'gs://tokenstorage/';
	}
} else {
	$file_storage_path = 'uploads/';
}
$database = "giftbox";
$user = "giftbox";
$password = "giftbox";
$app_name = "Giftbox";
$app_url = $prefix.$server.$app_root;
$sender_email = "founder@givetoken.com";
$message_recipient_email = "founder@givetoken.com";
