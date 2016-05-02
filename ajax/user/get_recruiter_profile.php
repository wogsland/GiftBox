<?php
use \Sizzle\Bacon\Database\{
    User
};

$success = 'false';
$data = '';
$user = new User($endpoint_parts[4] ?? 0);
if (isset($user->id)) {
    $data = $user->getRecruiterProfile();
    $success = 'true';
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
