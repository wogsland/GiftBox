<?php
use \GiveToken\EventLogger;

include_once 'config.php';
include_once 'database.php';

if (isset($_GET['uid']) && isset($_GET['key'])) {
	$user_id = $_GET['uid'];
	$key = $_GET['key'];
	try {
		$rows_affected = update("UPDATE user SET activation_key = NULL WHERE id = $user_id AND activation_key = '$key' LIMIT 1");
		if ($rows_affected != 1) {
			throw new Exception('Update failed');
		}
		$event = new EventLogger($user_id, ACTIVATE_ACCOUNT);
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
