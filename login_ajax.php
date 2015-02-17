<?php
include_once 'config.php';
include_once 'util.php';
include_once 'password.php';
include_once 'eventLogger.class.php';

zebra_session_start();

$user = null;
$event_type = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to log in at this time.";
$response['app_root'] = $app_root;

$email = $_POST['email'];
$login_type = $_POST['login-type'];
if (isset($_POST['password'])) {
	$password = $_POST['password'];
} else {
	$password = null;
}

// Try to find the user record using the email address
$sql = "SELECT * FROM user WHERE email_address = '$email' AND activation_key IS NULL";
$results = execute_query($sql);

if (!$results) {
	// The SQL failed to return a result for some reason.
	$response['status'] = "ERROR";
	$response['message'] = "Unable to log in at this time.";
} else {
	// We found a user record
	if ($results->num_rows == 1) {
		$user = $results->fetch_object();
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
				$event_type = LOGIN_USING_EMAIL;
				$response['status'] = 'SUCCESS';
			}
		}
		if ($response['status'] == 'SUCCESS') {
			$_SESSION['user_id'] = $user->id;
			$_SESSION['admin'] = $user->admin;
			$_SESSION['login_type'] = $login_type;
			$_SESSION['app_root'] = $app_root;
			$_SESSION['app_url'] = $app_url;
			$_SESSION['level'] = $user->level;
			$event = new eventLogger($user->id, $event_type);
			$event->log();
		}
	} else {
		$response['status'] = "ERROR";
		$response['message'] = "The email you entered does not belong to any account.";
	}
}

header('Content-Type: application/json');
echo json_encode($response);