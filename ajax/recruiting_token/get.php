<?php
use GiveToken\RecruitingToken;

// collect id
$id = isset($endpoint_parts[4]) ? (int) $endpoint_parts[4] : 0;

$success = 'false';
$data = '';
if ($id > 0) {
    $token = new RecruitingToken($id);
    if (isset($token->id)) {
        $success = 'true';
        $data = $token;
    } else {
        // id was not a token
    }
}
echo json_encode(array('success'=>$success, 'data'=>$data));
