<?php
include_once 'config.php';
include_once 'util.php';
include_once 'EventLogger.class.php';
require 'User.class.php';
_session_start();


$response['status'] = 'ERROR';
$user_id = $_SESSION['user_id'];

if(isset($_POST['access_token'])){
	if (isset($_SESSION['user_id'])) {
		$access_token = $_POST['access_token'];
		$response['result'] = execute("UPDATE user set access_token = '". $access_token ."' WHERE id = ". $user_id);
		$response['status'] = 'SUCCESS';
		$event = new EventLogger($user_id, UPDATE_ACCOUNT_INFO);
		$event->log();
	}	
}

header('Content-Type: application/json');
echo json_encode($response);