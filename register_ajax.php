<?php
use \GiveToken\User;
use \GiveToken\EventLogger;

include_once 'config.php';
include_once 'mail.php';
include_once 'database.php';

$event = null;
$user_id = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to register at this time.";
$response['app_root'] = $app_root;

$user = new User();
$user->email_address = $_POST['signup_email'];
$user->first_name = $_POST['first_name'];
$user->last_name = $_POST['last_name'];
if (isset($_POST['signup_password'])) {
	$user->password = $_POST['signup_password'];
} else {
	$user->password = null;
}
$user->level = $_POST['signup_level'];
$reg_type = $_POST['reg_type'];

// Make sure the email address is available:
if (User::exists($user->email_address)) {
	$response['status'] = "ERROR";
	$response['message'] = "The email address $user->email_address has already been registered.";
} else {
	if ($reg_type == 'EMAIL') {
		$user->activation_key = md5(uniqid(mt_rand(), false));
		$user->password = password_hash($user->password, PASSWORD_DEFAULT);
		$event = REGISTER_USING_EMAIL;
	} else if ($reg_type == 'FACEBOOK') {
		$user->activation_key = null;
		$user->password = null;
		$event = REGISTER_USING_FACEBOOK;
	}
	$user->save();
	$event = new EventLogger($user->getId(), $event);
	$event->log();

	if ($reg_type == 'EMAIL') {
		// Send the email
		$email_message = " To activate your GiveToken account, please click on this link:\n\n";
		$email_message .= $app_url . 'activate.php?uid=' . $user->getId() . "&key=$user->activation_key";
		sendMail($user->email_address, 'GiveToken Registration Confirmation', $email_message, $sender_email);
	}
	$response['status'] = "SUCCESS";
}

header('Content-Type: application/json');
echo json_encode($response);
