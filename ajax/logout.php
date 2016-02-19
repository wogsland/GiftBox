<?php
use \Sizzle\EventLogger;

$response['login_type'] = $_SESSION['login_type'] ?? null;
$response['app_root'] = '/';
if (isset($_SESSION['user_id'])) {
    (new EventLogger($_SESSION['user_id'], EventLogger::LOGOUT))->log();
}

session_unset();
session_destroy();

$response['status'] = "SUCCESS";

header('Content-Type: application/json');
echo json_encode($response);
