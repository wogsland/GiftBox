<?php
if ($_SERVER['SERVER_NAME'] == "giftbox.com") {
	$server = "localhost";
	$app_url = "http://giftbox.com";
	$app_root = "/";
} else if ($_SERVER['SERVER_NAME'] == "stone-timing-557.appspot.com") {
	$server = "173.194.244.175";
	$app_url = "http://stone-timing-557.appspot.com";
	$app_root = "/giftbox/";
}
$user = "giftbox";
$password = "giftbox";
$database = "giftbox";
$app_name = "Giftbox";
$sender_email = "admin@giftbox.com";
?>