<?php
include_once ('util.php');
include_once ('config.php');
include_once ('password.php');
include_once ('eventLogger.class.php');
include_once ('database.php');

$message = "Unable to register at this time.";
$email_address = $_GET['email'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$reg_type = $_GET['reg_type'];
$event = null;
$user_id = null;

if (isset($_GET['password'])) {
	$password = $_GET['password'];
} else {
	$password = null;
}
// Make sure the email address is available:
$sql = "SELECT * FROM user WHERE email_address ='$email_address'";
$result = execute_query($sql);
if (!$result) {
	$message = "Check for duplicate registered email address failed.";
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
			$email_message .= $app_url . '/activate.php?email=' . urlencode($email_address) . "&key=$activation_key";
			mail($email_address, 'Giftbox Registration Confirmation', $email_message, 'From:'. $sender_email);
		}
		$message = 'SUCCESS';

	} else { // The email address is not available
		$user = $result->fetch_object();
		if (!$user->password) {
			$message = "That email address has already been registered using Facebook.<br>Try logging in using Facebook.";
		} else {
			$message = "That email address has already been registered.<br>Try logging in using the email address.";
		}
	}
}

$json = '{"message":"'.$message.'"';
if ($message == "SUCCESS") {
	$json .= ',"user_id":"'.$user_id.'","app_root":"'.$app_root.'"';
}
$json .= '}';

echo $json;


?>
