<?php
use \GiveToken\ButtonLog;

$token_id = null;
if (isset($_GET['id'])) {
	$token_id = $_GET['id'];
}

if ($token_id) {
	$button_log = ButtonLog::getTokenButtonLog($token_id);
	var_dump($button_log);
}
