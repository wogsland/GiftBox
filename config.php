<?php
$server = $_SERVER['SERVER_NAME'];
 if ($server == "givetoken.com") {
	 $app_root = "/";
	 $app_url = "givetoken.com";
	 $use_google_mail = true;
} else {
    $app_root = "/giftbox";
	$app_url = "http://".$server."/giftbox";
	$use_google_mail = false;
}
$database = "giftbox";
$user = "giftbox";
$password = "giftbox";
$app_name = "Giftbox";
$sender_email = "john_hall@corridor-inc.com";
?>