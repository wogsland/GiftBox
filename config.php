<?php
$google_app_engine = false;
$server = $_SERVER['SERVER_NAME'];
$prefix = "http://";
$use_https = false;
$socket = null;
if (isset($_SERVER['HTTPS'])) {
	if ($_SERVER['HTTPS'] === "on") {
		$prefix = "https://";
		$use_https = true;
	}
}
if (isset($_SERVER["HTTP_X_APPENGINE_COUNTRY"])) {
	$app_root = "/";
	$google_app_engine = true;
	if ($_SERVER["APPLICATION_ID"] === "s~stone-timing-557") {
		$file_storage_path = 'gs://tokenstorage/';
		$socket = '/cloudsql/stone-timing-557:test';
	} elseif ($_SERVER["APPLICATION_ID"] === "s~t-sunlight-757") {
		$file_storage_path = 'gs://tokenstorage-staging/';
		$socket = '/cloudsql/t-sunlight-757:staging';
	}
} else {
    $app_root = "/giftbox/";
	$file_storage_path = 'uploads/';
}
$database = "giftbox";
$user = "giftbox";
$password = "giftbox";
$app_name = "Giftbox";
$app_url = $prefix.$server.$app_root;
$sender_email = "john_hall@corridor-inc.com";
$message_recipient_email = "john_hall@corridor-inc.com";
