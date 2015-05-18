<?php
include_once 'config.php';
include_once 'util.php';
include_once 'EventLogger.class.php';

$response['status'] = 'ERROR';
$session = _session_start();

if(isset($_POST['access_token'])){
	$access_token = $_POST['access_token'];
	$response['result'] = execute("UPDATE user set access_token = '". $access_token ."' WHERE id = ". $_SESSION['user_id']);
	$response['status'] = 'SUCCESS';
	$event = new EventLogger($_SESSION['user_id'], UPDATE_ACCOUNT_INFO);
	$event->log();
}

header('Content-Type: application/json');
echo json_encode($response);