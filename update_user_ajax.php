<?php
include_once 'util.php';
require_once('EventLogger.class.php');
require_once('User.class.php');

$user_id = $_POST['user_id'];
$user = new User($user_id);
$user->first_name = $_POST['first_name'];
$user->last_name = $_POST['last_name'];
$user->email_address = $_POST['email'];
$user->level = $_POST['level'];
if (isset($_POST['admin'])) {
	$user->admin = $_POST['admin'];
} else {
	$user->admin = "N";
}
$user->save();
?>