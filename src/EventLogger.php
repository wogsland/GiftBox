<?php
namespace GiveToken;

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
        $sql = "INSERT INTO event_log (user_id, event_type_id, event_info) values ('".$this->user_id."', '".$this->event_type_id."', '".$this->event_info."')";
        execute($sql);
    }
}

?>
