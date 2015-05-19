<?php
include_once 'config.php';
include_once 'util.php';
include_once 'EventLogger.class.php';
require 'User.class.php';


$response['status'] = 'ERROR';
$email = $_POST['email'];

if(isset($_POST['access_token'])){
	if (User::exists($email)) {
		$user = User::fetch($email);
		$access_token = $_POST['access_token'];
		$user_id = $user->getId();
		$response['result'] = execute("UPDATE user set access_token = '". $access_token ."' WHERE id = ". $user_id);
		$response['status'] = 'SUCCESS';
		$event = new EventLogger($user_id, UPDATE_ACCOUNT_INFO);
		$event->log();
	}	
}

header('Content-Type: application/json');
echo json_encode($response);