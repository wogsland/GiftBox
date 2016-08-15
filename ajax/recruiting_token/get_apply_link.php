<?php
use \Sizzle\Bacon\Database\{
    RecruitingToken,
    User
};

// collect id
$id = $endpoint_parts[4] ?? '';

$success = 'false';
$data = '';
$errors = [];
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id, $token->apply_link)) {
        $success = 'true';
        $data = $token->apply_link;
    }
} else {
    $errors[] = 'Token ID required';
}
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data, 'errors'=>$errors);
echo json_encode($result);
