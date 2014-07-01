<?php
include_once 'util.php';
include_once 'eventLogger.class.php';

$message = "Unable to update the user at this time.";
$user_id = $_GET['user_id'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$email_address = $_GET['email'];
$admin = $_GET['admin'];
$sql = "UPDATE user set first_name = '".$first_name."', last_name = '".$last_name."', email_address = '".$email_address."' admin = '".$admin."' WHERE id = ".$user_id;
execute($sql);
// $event = new eventLogger($_COOKIE['user_id'], MODIFY_USER);
// $event->log();
$message = "SUCCESS";

$json = '{"message":"'.$message.'"}';
echo $json;

?>
