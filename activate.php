<?php
include_once 'config.php';
include_once 'util.php';
include_once 'database.php';
include_once 'eventLogger.class.php';

if (isset($_GET['email']) && isset($_GET['key'])) {
	$email = $_GET['email'];
	$key = $_GET['key'];
	try {
		$rows_affected = update("UPDATE user SET activation_key = NULL WHERE email_address = '$email' AND activation_key = '$key' LIMIT 1");
		if ($rows_affected != 1) {
			throw new Exception('Update failed');
		}
		$user_id = execute_query("SELECT id from user where email_address = '$email'")->fetch_object()->id;
		$event = new eventLogger($user_id, ACTIVATE_ACCOUNT);
		$event->log();
		echo '<div>Your account is now active. You may now <a href="'.$app_root.'">Log in</a></div>';
	} catch (Exception $e) {
		echo '<div>Your account could not be activated. Please recheck the link or contact the system administrator.</div>';
		echo $e->getMessage();
	}
} else {
	echo '<div>Your account could not be activated. Please recheck the link or contact the system administrator.</div>';
}
 
?>