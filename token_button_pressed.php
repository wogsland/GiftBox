<?php
use \GiveToken\ButtonLog;

include_once 'config.php';

_session_start();

// Save the button press
$button_log = new ButtonLog();
$button_log->giftbox_id = $_GET['id'];
$button_log->button = $_GET['button'];
$button_log->save();

$response['status'] = "SUCCESS";
$response['id'] = $button_log->id;

header('Content-Type: application/json');
echo json_encode($response);
