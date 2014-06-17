<?php
include_once ('util.php');
include_once ('password.php');
include_once ('eventLogger.class.php');

$message = "Unable to log in at this time.";
$user = null;
$email = $_GET['email'];
$login_type = $_GET['login_type'];
$event = null;
if (isset($_GET['password'])) {
	$password = $_GET['password'];
} else {
	$password = null;
}

// Try to find the user record using the email address
$sql = "SELECT * FROM user WHERE email_address = '$email' AND activation_key IS NULL";
$results = execute_query($sql);

if (!$results) {
	// The SQL failed to return a result for some reason.
	$message = "Unable to log in at this time.";
} else {
	// We found a user record
	if ($results->num_rows == 1) {
		$user = $results->fetch_object();
		if ($login_type == 'FACEBOOK') {
				$message = 'SUCCESS';
				$event = LOGIN_USING_FACEBOOK;
		} else if ($login_type == 'EMAIL') {
			if (!$user->password) {
				$message = 'This account was created using Facebook.<br>Please use the Log In With FaceBook button.';
			} else if (!password_verify($password, $user->password)) {
				$message = 'The password you entered is incorrect.';
			} else {
				$message = 'SUCCESS';
				$event = LOGIN_USING_EMAIL;
			}
		}
		if ($message == 'SUCCESS') {
			$event = new eventLogger($user->id, $event);
			$event->log();
		}
	} else {
		$message = "The email you entered does not belong to any account.";
	}
}

$json = '{"message":"'.$message.'"';
if ($message == "SUCCESS") {
	if ($user) {
		$json .= ',"user_id":"'.$user->id.'","email_address":"'.$user->email_address.'","first_name":"'.$user->first_name.'","last_name":"'.$user->last_name.'"';
	}
}
$json .= '}';

echo $json;

?>
