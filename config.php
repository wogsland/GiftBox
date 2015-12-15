<?php
define('VERSION', '1.8.0');

// autoload classes
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/vendor/stefangabos/zebra_session/Zebra_Session.php';

//load functions
require_once __DIR__.'/util.php';

$server = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
if ('givetoken.com' == strtolower($server)
    || 'stone-timing-557.appspot.com' == strtolower($server)
) {
    $url = 'https://www.givetoken.com'.$_SERVER['REQUEST_URI'];
    header("Location: $url ", true, 301);
}
if (!defined('DEVELOPMENT')) {
    define('DEVELOPMENT', ('www.givetoken.com' != $server));
}
$google_app_engine = false;
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
    } else {
        if('www.givetoken.com' == $server) {
            $url = 'https://www.givetoken.com'.$_SERVER['REQUEST_URI'];
            header("Location: $url ", true, 301);
        }
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
if (!defined('FILE_STORAGE_PATH')) {
    define('FILE_STORAGE_PATH', $file_storage_path);
}

$database = "giftbox";
$user = "giftbox";
$password = "giftbox";
$app_name = "Giftbox";
$app_url = $prefix.$server.$app_root;
$sender_email = "founder@givetoken.com";
$message_recipient_email = "founder@givetoken.com";

// connect to database
if ($google_app_engine) {
    $mysqli = new mysqli(null, $user, $password, $database, null, $socket);
} else {
    if (in_array($server, array('','givetoken.local'))) {
        $mysql_server = "127.0.0.1";
    } else {
        $mysql_server = 'p:'.$server;
    }
    $mysqli = new mysqli($mysql_server, $user, $password, $database);
}
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
new GiveToken\Connection($mysqli);

// start session
$session = _session_start();

// record website hit
if (isset($_COOKIE, $_COOKIE['visitor'])) {
    $visitor_cookie = $_COOKIE['visitor'];
} else {
    $visitor_cookie = substr(md5(microtime()), rand(0, 26), 20);
}
// set or reset cookie to expire in a year
setcookie('visitor', $visitor_cookie, time()+60*60*24*365);
if (isset($_SESSION, $_SESSION['user_id'])) {
    $user_id = escape_string($_SESSION['user_id']);
    $insert_user_id = ' `user_id`, ';
    $value_user_id = " '{$user_id}', ";
} else {
    $insert_user_id = '';
    $value_user_id = '';
}
if (isset($_SERVER)) {
    $host = isset($_SERVER['HTTP_HOST']) ? escape_string($_SERVER['HTTP_HOST']) : '';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? escape_string($_SERVER['HTTP_USER_AGENT']) : '';
    $uri = isset($_SERVER['REQUEST_URI']) ? escape_string($_SERVER['REQUEST_URI']) : '';
    $remote_ip = isset($_SERVER['REMOTE_ADDR']) ? escape_string($_SERVER['REMOTE_ADDR']) : '';
    $script = isset($_SERVER['SCRIPT_NAME']) ? escape_string($_SERVER['SCRIPT_NAME']) : '';
    $query = "INSERT INTO web_request
        ($insert_user_id `visitor_cookie`, `host`, `user_agent`, `uri`, `remote_ip`, `script`)
        VALUES
        ($value_user_id '$visitor_cookie', '$host', '$user_agent', '$uri', '$remote_ip', '$script')";
    insert($query);
}
