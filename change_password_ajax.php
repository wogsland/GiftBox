<?php
include_once 'config.php';
include_once 'util.php';
include_once 'password.php';
include_once 'EventLogger.class.php';

$message = "Unable to change password at this time.";
$user_id = $_POST['user_id'];
$new_password = $_POST['new_password'];
$hash = password_hash($new_password, PASSWORD_DEFAULT);
if ($user_id and $new_password) {
	print_r($user_id);
	print_r($new_password);
	execute("UPDATE user set password = '".$hash."' WHERE id = ".$user_id);
}
$event = new EventLogger($_POST['user_id'], CHANGE_PASSWORD);
$event->log();
$message = "SUCCESS";

$json = '{"message":"'.$message.'"}';
echo $json;

?>
