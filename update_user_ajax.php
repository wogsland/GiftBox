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
$user->location = $_POST['location'];
$user->company = $_POST['company'];
$user->position = $_POST['position'];
$user->about = $_POST['about'];
$user->social = $_POST['social'];
$user->username = $_POST['username'];
$user->user_group = $_POST['group'];

if(is_array($user->social)){
	$social = new Social(null);
	foreach ($user->social as $category){
		$social->network = $category["name"];
		$social->user_id = $user_id;
		$social->url = $category["url"];
		$social->save();
	}
}

// admin
if (isset($_POST['admin'])) {
	$user->admin = $_POST['admin'];
} else {
	$user->admin = "N";
}

// group admin
if (strlen($user->user_group) > 0 AND isset($_POST['group_admin'])) {
	$user->group_admin = $_POST['group_admin'];
} else {
	$user->group_admin = "N";
}

$user->save();
?>