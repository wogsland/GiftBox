<?php
use GiveToken\RecruitingToken;

// collect id
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : 0;

$success = 'false';
$data = '';
if ($id > 0) {
    $token = new RecruitingToken($id, 'long_id');
    print_r($token);
    if (isset($token->id)) {
        $success = 'true';
        $data = $token;
    }
}
echo json_encode(array('success'=>$success, 'data'=>$data));
