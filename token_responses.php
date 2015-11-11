<?php
use \GiveToken\ButtonLog;

require_once __DIR__.'/config.php';
_session_start();
if (!logged_in()) {
    header('Location: '.$app_root);
}

define('TITLE', 'GiveToken.com - Token Responses');
require __DIR__.'/header.php';

$token_id = null;
if (isset($_GET['id'])) {
    $token_id = $_GET['id'];
}

if ($token_id) {
    $button_log = ButtonLog::getTokenButtonLog($token_id);
    var_dump($button_log);
}
