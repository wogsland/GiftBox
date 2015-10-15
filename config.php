<?php
// autoload classes
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/vendor/stefangabos/zebra_session/Zebra_Session.php';

//load functions
require_once __DIR__.'/util.php';

$google_app_engine = false;
$server = $_SERVER['SERVER_NAME'];
$prefix = "http://";
$app_root = "/";
$use_https = false;
$socket = null;
$stripe_secret_key = 'sk_test_RTcVNjcQVfYNiPCiY5O9CevV';
$stripe_publishable_key = 'pk_test_Gawg5LhHJ934MPXlvglZrdnL';
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
		$stripe_secret_key = 'sk_live_MuUj2k3WOTpvIgw8oIHaON2X';
		$stripe_publishable_key = 'pk_live_AbtrrWvSZZCvLYdiLohHC2Kz';
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

//define event constants
define('REGISTER_USING_EMAIL', 1);
define('REGISTER_USING_FACEBOOK', 2);
define('LOGIN_USING_EMAIL', 3);
define('LOGIN_USING_FACEBOOK', 4);
define('LOGOUT', 5);
define('ACTIVATE_ACCOUNT', 6);
define('SEND_GIFTBOX', 7);
define('UPDATE_ACCOUNT_INFO', 8);
define('CHANGE_PASSWORD', 9);
define('UPGRADE', 10);
define('UPDATE_FACEBOOK_ACCESS_TOKEN', 11);
