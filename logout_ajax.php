<?php
include_once ('eventLogger.class.php');

$event = new eventLogger($_GET['user_id'], LOGOUT);
try {
	$event->log();
	echo '{"message":"SUCCESS"}';
} catch (Exception $e) {
	echo '{"message":"'.$e->getMessage().'"}';
}
?>
