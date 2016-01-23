<?php
use Monolog\ErrorHandler;
use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use Sizzle\Connection;

// set relesae version
define('VERSION', '1.9.2');

// autoload classes
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';

//load functions
require_once __DIR__.'/util.php';

// Determine environment & fix URL as needed
$server = $_SERVER['SERVER_NAME'] ?? null;
if ('givetoken.com' == strtolower($server)
    || 'stone-timing-557.appspot.com' == strtolower($server)
) {
    $url = 'https://www.givetoken.com'.$_SERVER['REQUEST_URI'];
    header("Location: $url ", true, 301);
}
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'www.givetoken.com' == $server ? 'production' : ('127.0.0.1' == $_SERVER['SERVER_ADDR'] ? 'local' : 'development'));
}


// setup Monolog error handler to report to Slack
// this causes a 500 error on AWS (is PHP 7 issue?)
if (!defined('SLACK_TOKEN')) {
    define('SLACK_TOKEN', 'xoxb-17521146128-nHU6t4aSx7NE0PYLxKRYqmjG');
}
/*$logger = new Logger('bugs');
if (ENVIRONMENT != 'local') {
  if (ENVIRONMENT == 'development') {
      $name = 'Dev Application: '.$_SERVER['REQUEST_URI'];
      $slackHandler = new SlackHandler(SLACK_TOKEN, '#bugs-staging', $name, false);
  } else {
      $name = 'Web Application: '.$_SERVER['REQUEST_URI'];
      $slackHandler = new SlackHandler(SLACK_TOKEN, '#bugs', $name, false);
  }
  $slackHandler->setLevel(Logger::DEBUG);
  $logger->pushHandler($slackHandler);
  ErrorHandler::register($logger);
}*/

$google_app_engine = false;
$prefix = "http://";
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
    define('GOOGLE_APP_ID', $_SERVER["APPLICATION_ID"]);
    $google_app_engine = true;
    if (GOOGLE_APP_ID === "s~stone-timing-557") {
        $file_storage_path = 'gs://tokenstorage/';
        $socket = '/cloudsql/stone-timing-557:test';
        $stripe_secret_key = 'sk_live_MuUj2k3WOTpvIgw8oIHaON2X';
        $stripe_publishable_key = 'pk_live_AbtrrWvSZZCvLYdiLohHC2Kz';
    } elseif (GOOGLE_APP_ID === "s~t-sunlight-757") {
        $file_storage_path = 'gs://tokenstorage-staging/';
        $socket = '/cloudsql/t-sunlight-757:staging';
    } else {
        $file_storage_path = 'gs://tokenstorage/';
    }
} else {
    $file_storage_path = 'uploads/';
}
if (!defined('GOOGLE_APP_ENGINE')) {
    define('GOOGLE_APP_ENGINE', $google_app_engine);
}
if (!defined('STRIPE_SECRET_KEY')) {
    define('STRIPE_SECRET_KEY', $stripe_secret_key);
}
if (!defined('STRIPE_PUBLISHABLE_KEY')) {
    define('STRIPE_PUBLISHABLE_KEY', $stripe_publishable_key);
}
if (!defined('FILE_STORAGE_PATH')) {
    define('FILE_STORAGE_PATH', $file_storage_path);
}

if (!defined('APP_URL')) {
    define('APP_URL', $prefix.$server.'/');
}

// connect to database
switch (ENVIRONMENT) {
    case 'production':
    $database = "giftbox";
    $user = "giftbox";
    $password = "giftbox";
    $mysqli = new mysqli(null, $user, $password, $database, null, $socket);
    break;
    case 'development';
    case 'local';
    include __DIR__.'/config/credentials.php';
    $mysqli = new mysqli($mysql_server, $user, $password, $database);
}
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
new Connection($mysqli);

// start session
session_start();

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
