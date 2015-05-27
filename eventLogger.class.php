<?php
include_once 'util.php';
include_once 'EventLogger.class.php';


define('REGISTER_USING_EMAIL', 1);
define('REGISTER_USING_FACEBOOK', 2);
define('LOGIN_USING_EMAIL', 3);
define('LOGIN_USING_FACEBOOK', 4);
define('LOGOUT', 5);
define('ACTIVATE_ACCOUNT', 6);
define('SEND_GIFTBOX', 7);
define('UPDATE_ACCOUNT_INFO', 8);
define('CHANGE_PASSWORD', 9);
define('UPGRADE', 10);
define('UPDATE_FACEBOOK_ACCESS_TOKEN', 11);

class EventLogger {
	var $id;
	var $user_id;
	var $event_type_id;
	var $event_time;
	var $event_info;
	
	public function __construct($inUserId, $inEventTypeId, $inEventInfo = null) {
		$this->user_id = $inUserId;
		$this->event_type_id = $inEventTypeId;
		$this->event_info = $inEventInfo;
	}

	function log() {
		$sql = "INSERT INTO event_log (user_id, event_type_id, event_info) values (".$this->user_id.", ".$this->event_type_id.", '".$this->event_info."')";
		execute($sql);
	}
} //Class EventLogger

?>
