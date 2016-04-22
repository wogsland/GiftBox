<?php
use \Sizzle\Bacon\Database\{
    User
};

$response['status'] = 'ERROR';
if (isset($_SESSION['user_id'])) {
    $user = new User($_SESSION['user_id']);
} else if (isset($_POST['email']) && (new User())->exists($_POST['email'])) {
    $user = (new User())->fetch($_POST['email']);
} else {
    $user = null;
    $response['status'] = 'NO_USER';
}

if ($user != null && isset($_POST['access_token'])) {
    $access_token = $_POST['access_token'];
    $user->update_token($access_token, $user->id);
    $response['status'] = 'SUCCESS';
}

header('Content-Type: application/json');
echo json_encode($response);
