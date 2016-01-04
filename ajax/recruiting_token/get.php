<?php
use \GiveToken\HTML;
use \GiveToken\RecruitingToken;

// collect id
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';

$success = 'false';
$data = '';
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $success = 'true';
        $data = $token;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
