<?php
namespace GiveToken;

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

class EventLogger
{
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
        $sql = "INSERT INTO event_log (user_id, event_type_id, event_info) values (".$this->user_id.", ".$this->event_type_id.", '".$this->event_info."')";
        execute($sql);
    }
}

?>
