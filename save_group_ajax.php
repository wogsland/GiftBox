<?php
use \GiveToken\UserGroup;

include_once 'config.php';
//include_once 'UserGroup.class.php';

try {
	// Save the group
	$user_group = new UserGroup();
	$action = $_POST['action'];
	if (isset($_POST['group_id'])) {
		$user_group->id = $_POST['group_id'];
	}
	$user_group->name = $_POST['group_name'];
	$user_group->max_users = $_POST['max_users'];

	if($action == "ADD" || $action == "EDIT") {
		$user_group->save();
	} else if ($action == "DELETE") {
		$user_group->delete();
	}

	$response['status'] = "SUCCESS";
	$response['group_id'] = $user_group->id;
} catch (Exception $e) {
	$response['status'] = "ERROR";
	$response['message'] = $e->getMessage();
	$repsonse['object'] = $e;
}
header('Content-Type: application/json');
echo json_encode($response);
