<?php
use \GiveToken\Token;

include_once 'config.php';

_session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	try {

		// Save the token
		$token = new Token();
		$token->init((object)$_POST);
		$token->user_id = $user_id;
		$token->save();

		$response['status'] = "SUCCESS";
		$response['giftbox_id'] = $token->id;
		$response['app_url'] = $app_url;
	} catch (Exception $e) {
		$response['status'] = "ERROR";
		$response['message'] = $e->getMessage();
		$repsonse['object'] = $e;
	}
} else {
	$response['status'] = "ERROR";
	$response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
