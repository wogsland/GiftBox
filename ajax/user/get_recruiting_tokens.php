<?php
use \Sizzle\HTML;
use \Sizzle\RecruitingToken;

// collect id
$user_id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';

$success = 'false';
$data = '';
if (((int)$user_id == $user_id && is_admin()) || (logged_in() && $user_id == $_SESSION['user_id'])) {
    /*$token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $success = 'true';
        $data = $token;
    }*/
    $tokens = execute_query(
        "SELECT long_id, job_title
         FROM recruiting_token
         WHERE user_id = '$user_id'
         ORDER BY job_title, long_id"
    )->fetch_all(MYSQLI_ASSOC);
    $data = $tokens;
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
