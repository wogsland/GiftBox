<?php
use \Sizzle\{
    RecruitingToken,
    User
};

// collect id
$id = escape_string($endpoint_parts[4] ?? '');

$success = 'false';
$allowed = 'true';
$errors = [];
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $user = new User($token->user_id);
        if (isset($user->allow_token_responses)) {
            $success = 'true';
            if ('N' == $user->allow_token_responses) {
                $allowed = 'false';
            }
        } else {
            $errors[] = 'Unknown token creator';
        }
    } else {
        $errors[] = 'Unknown token';
    }
} else {
    $errors[] = 'Token ID required';
}
$data = array('allowed'=>$allowed);
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data, 'errors'=>$errors);
echo json_encode($result);
