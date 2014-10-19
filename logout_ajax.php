<?php
include_once 'config.php';
include_once ('eventLogger.class.php');
session_start();

$response['login_type'] = $_SESSION['login_type'];
$response['app_root'] = $app_root;
$event = new eventLogger($_SESSION['user_id'], LOGOUT);
$event->log();

session_unset();
session_destroy();

$response['status'] = "SUCCESS";

header('Content-Type: application/json');
echo json_encode($response);