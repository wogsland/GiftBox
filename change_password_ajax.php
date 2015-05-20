<?php
include_once 'config.php';
include_once 'util.php';
include_once 'password.php';
include_once 'eventLogger.class.php';

$message = "Unable to change password at this time.";
$user_id = $_GET['user_id'];
$new_password = $_GET['new_password'];
$hash = password_hash($new_password, PASSWORD_DEFAULT);
execute("UPDATE user set password = '".$hash."' WHERE id = ".$user_id);
$event = new eventLogger($_GET['user_id'], CHANGE_PASSWORD);
$event->log();
$message = "SUCCESS";

$json = '{"message":"'.$message.'"}';
echo $json;

?>
