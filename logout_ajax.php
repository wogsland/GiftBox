<?php
use \GiveToken\EventLogger;

include_once 'config.php';

$session = _session_start();

$response['login_type'] = $_SESSION['login_type'];
$response['app_root'] = $app_root;
$event = new EventLogger($_SESSION['user_id'], LOGOUT);
$event->log();

$session->stop();
//session_unset();
//session_destroy();

$response['status'] = "SUCCESS";

header('Content-Type: application/json');
echo json_encode($response);
