<?php
namespace GiveToken;

class EventLogger
{
	const REGISTER_USING_EMAIL = 1;
	const REGISTER_USING_FACEBOOK = 2;
	const LOGIN_USING_EMAIL = 3;
	const LOGIN_USING_FACEBOOK = 4;
	const LOGOUT = 5;
	const ACTIVATE_ACCOUNT = 6;
	const SEND_GIFTBOX = 7;
	const UPDATE_ACCOUNT_INFO = 8;
	const CHANGE_PASSWORD = 9;
	const UPGRADE = 10;
	const UPDATE_FACEBOOK_ACCESS_TOKEN = 11;
	
    public $id;
    public $user_id;
    public $event_type_id;
    public $event_time;
    public $event_info;

    public function __construct($inUserId, $inEventTypeId, $inEventInfo = null)
    {
        $this->user_id = $inUserId;
        $this->event_type_id = $inEventTypeId;
        $this->event_info = $inEventInfo;
    }

    public function log()
    {
        $sql = "INSERT INTO event_log (user_id, event_type_id, event_info) values ('".$this->user_id."', '".$this->event_type_id."', '".$this->event_info."')";
        execute($sql);
    }
}

?>
