<?php
include_once 'util.php';
include_once 'config.php';
include_once 'mail.php';
include_once 'password.php';
include_once 'eventLogger.class.php';
include_once 'database.php';

$event = null;
$user_id = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to register at this time.";
$response['app_root'] = $app_root;

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email_address = $_POST['email'];
if (isset($_POST['password'])) {
	$password = $_POST['password'];
} else {
	$password = null;
}
$reg_type = $_POST['reg_type'];

// Make sure the email address is available:
$sql = "SELECT * FROM user WHERE email_address ='$email_address'";
$result = execute_query($sql);
if (!$result) {
	$response['status'] = "ERROR";
	$response['message'] = "Check for duplicate registered email address failed.";
} else {

	if ($result->num_rows == 0) { // If no previous user is using this email

		if ($reg_type == 'EMAIL') {
			$activation_key = md5(uniqid(mt_rand(), false));
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$event = REGISTER_USING_EMAIL;
		} else if ($reg_type == 'FACEBOOK') {
			$activation_key = null;
			$password_hash = null;
			$event = REGISTER_USING_FACEBOOK;
		}

		$sql = "INSERT INTO user (email_address, first_name, last_name, password, activation_key) VALUES ('$email_address', '$first_name', '$last_name', ".($password ? "'".$password_hash."'" : 'NULL').", ".($activation_key ? "'".$activation_key."'" : 'NULL').")";
		$user_id = insert($sql);
		$event = new eventLogger($user_id, $event);
		$event->log();

		if ($reg_type == 'EMAIL') {
			// Send the email
			$email_message = " To activate your Giftbox account, please click on this link:\n\n";
			$email_message .= $app_url . 'activate.php?uid=' . $user_id . "&key=$activation_key";
			sendMail($email_address, 'Giftbox Registration Confirmation', $email_message, $sender_email);
		}
		$response['status'] = "SUCCESS";

	} else { // The email address is not available
		$response['status'] = "ERROR";
		$user = $result->fetch_object();
		if (!$user->password) {
			$response['message'] = "That email address has already been registered using Facebook. Try logging in using Facebook.";
		} else {
			$response['message'] = "That email address has already been registered. Try logging in using the email address.";
		}
	}
}

header('Content-Type: application/json');
echo json_encode($response);