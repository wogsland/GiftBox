<?php
use Sizzle\RecruitingTokenResponse;

// collect info from url
$id = escape_string($endpoint_parts[4] ?? '');
$email = escape_string($endpoint_parts[5] ?? '');
$email = urldecode($email);
$response = escape_string($endpoint_parts[6] ?? '');
$response = ucfirst(strtolower($response));
$cookie = escape_string($_COOKIE['visitor'] ?? '');

$success = 'false';
$data = '';
$RecruitingTokenResponse = new RecruitingTokenResponse();
$id = $RecruitingTokenResponse->create($id, $email, $response, $cookie);
if ($id > 0) {
    $success = 'true';
    $data = array('id'=>$id);
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
