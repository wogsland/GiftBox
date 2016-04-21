<?php
use \Sizzle\Bacon\Database\RecruitingToken;

// collect id
$id = $endpoint_parts[4] ?? '';

$success = 'false';
$data = '';
if ($id != '') {
    $success = 'true';
    $data = (new RecruitingToken($id, 'long_id'))->getCities();
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
