<?php
use \Sizzle\EventLogger;

$response['login_type'] = $_SESSION['login_type'];
$response['app_root'] = '/';
$event = new EventLogger($_SESSION['user_id'], EventLogger::LOGOUT);
$event->log();

$session->stop();
//session_unset();
//session_destroy();

$response['status'] = "SUCCESS";

header('Content-Type: application/json');
echo json_encode($response);
