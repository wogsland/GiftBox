<?php
use GiveToken\RecruitingTokenResponse;

// collect info from url
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';
$email = isset($endpoint_parts[5]) ? escape_string($endpoint_parts[5]) : '';
$email = urldecode($email);
$response = isset($endpoint_parts[6]) ? escape_string($endpoint_parts[6]) : '';
$response = ucfirst(strtolower($response));

$success = 'false';
$data = '';
$RecruitingTokenResponse = new RecruitingTokenResponse();
$id = $RecruitingTokenResponse->create($id, $email, $response);
if ($id > 0) {
    $success = 'true';
    $data = array('id'=>$id);
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
