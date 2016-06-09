<?php
use \Sizzle\Bacon\Database\{
    RecruitingToken,
    User
};

// collect id
$id = $endpoint_parts[4] ?? '';

$success = 'false';
$allowed = 'true';
$autoPop = 'true';
$autoPopDelay = 10;
$collectName = 'true';
$errors = [];
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $user = new User($token->user_id);
        if (isset($user->allow_token_responses)) {
            $success = 'true';
            if ('N' == $user->allow_token_responses) {
                $allowed = 'false';
            } else {
                if ('N' == $token->auto_popup) {
                    $autoPop = 'false';
                } else {
                    $autoPopDelay = $token->auto_popup_delay;
                }
                if ('N' == $token->collect_name) {
                    $collectName = 'false';
                }
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
$data = array(
    'allowed'=>$allowed,
    'autoPop'=>$autoPop,
    'autoPopDelay'=>$autoPopDelay,
    'collectName'=>$collectName
);
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data, 'errors'=>$errors);
echo json_encode($result);
