<?php
include_once 'config.php';
include_once 'util.php';
include_once 'password.php';
include_once 'eventLogger.class.php';
require 'User.class.php';

_session_start();

$user = null;
$event_type = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to log in at this time.";
$response['app_root'] = $app_root;

$email = $_POST['login_email'];
$login_type = $_POST['login_type'];
if (isset($_POST['password'])) {
	$password = $_POST['password'];
} else {
	$password = null;
}

if (User::exists($email)) {
	$user = User::fetch($email);
	if ($login_type == 'FACEBOOK') {
			$event_type = LOGIN_USING_FACEBOOK;
			$response['status'] = 'SUCCESS';
	} else if ($login_type == 'EMAIL') {
		if (!$user->password) {
			$response['status'] = "ERROR";
			$response['message'] = "This account was created using Facebook.<br>Please use the Log In With FaceBook button.";
		} else if (!password_verify($password, $user->password)) {
			$response['status'] = "ERROR";
			$response['message'] = 'The password you entered is incorrect.';
		} else {
			if ($user->activation_key) {
				$response['status'] = "ERROR";
				$response['message'] = "The account exists but has not been activated yet.";
			} else {
				$event_type = LOGIN_USING_EMAIL;
				$response['status'] = 'SUCCESS';
			}
		}
	}
	if ($response['status'] == 'SUCCESS') {
		$_SESSION['user_id'] = $user->getId();
		$_SESSION['admin'] = $user->admin;
		$_SESSION['login_type'] = $login_type;
		$_SESSION['app_root'] = $app_root;
		$_SESSION['app_url'] = $app_url;
		$_SESSION['level'] = $user->level;
		$event = new eventLogger($user->getId(), $event_type);
		$event->log();
	}
} else {
	$response['status'] = "ERROR";
	$response['message'] = "The email address \"".$email."\" does not belong to any GiveToken account.";
}

header('Content-Type: application/json');
echo json_encode($response);