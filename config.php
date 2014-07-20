<?php
if ($_SERVER['SERVER_NAME'] == "localhost") {
	$server = "localhost";
    $app_root = "/giftbox";
	$app_url = "http://localhost/giftbox";
	$use_google_mail = false;
} else if ($_SERVER['SERVER_NAME'] == "stone-timing-557.appspot.com") {
	$server = "stone-timing-557.appspot.com";
    $app_root = "/";
	$app_url = "http://stone-timing-557.appspot.com";
	$use_google_mail = true;
}
$user = "giftbox";
$password = "giftbox";
$database = "giftbox";
$app_name = "Giftbox";
$sender_email = "john_hall@corridor-inc.com";
?>