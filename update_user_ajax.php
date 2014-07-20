<?php
include_once 'util.php';
include_once 'eventLogger.class.php';

$user_id = $_REQUEST['user_id'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$email_address = $_REQUEST['email'];
if (isset($_REQUEST['admin'])) {
	$admin = $_REQUEST['admin'];
} else {
	$admin = "N";
}

$sql = "UPDATE user set first_name = '".$first_name."', last_name = '".$last_name."', email_address = '".$email_address."', admin = '".$admin."' WHERE id = ".$user_id;
execute($sql);
?>