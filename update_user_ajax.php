<?php
include_once 'util.php';
include_once 'EventLogger.class.php';

$user_id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email_address = $_POST['email'];
if (isset($_POST['admin'])) {
	$admin = $_POST['admin'];
} else {
	$admin = "N";
}

$sql = "UPDATE user set first_name = '".$first_name."', last_name = '".$last_name."', email_address = '".$email_address."', admin = '".$admin."' WHERE id = ".$user_id;
execute($sql);
?>