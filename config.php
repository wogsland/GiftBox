<?php
$google_app_engine = false;
$server = $_SERVER['SERVER_NAME'];

if (isset($_SERVER["HTTP_X_APPENGINE_DEFAULT_NAMESPACE"])) {
	$app_root = "/";
	$app_url = "givetoken.com";
	$google_app_engine = true;
	$file_storage_path = 'gs://tokenstorage/';
} else {
    $app_root = "/giftbox";
	$app_url = "http://".$server."/giftbox";
	$file_storage_path = 'uploads/'
}
$database = "giftbox";
$user = "giftbox";
$password = "giftbox";
$app_name = "Giftbox";
$sender_email = "john_hall@corridor-inc.com";
?>