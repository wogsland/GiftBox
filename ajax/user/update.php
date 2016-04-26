<?php
use \Sizzle\Bacon\Database\{
    User
};

$response = [];
if (logged_in()) {

    try {
        $user = new User($_POST['user_id'] ?? null);

        $user->first_name = $_POST['first_name'] ?? null;
        $user->last_name = $_POST['last_name'] ?? null;
        $user->email_address = $_POST['email'] ?? null;
        $user->location = $_POST['location'] ?? null;
        $user->company = $_POST['company'] ?? null;
        $user->position = $_POST['position'] ?? null;
        $user->about = $_POST['about'] ?? null;
        $user->username = $_POST['username'] ?? null;
        $user->user_group = $_POST['group'] ?? null;
        $user->allow_token_responses = $_POST['allow_token_responses'] ?? null;
        $user->receive_token_notifications = $_POST['receive_token_notifications'] ?? null;

        // password
        if (isset($_POST['password']) && strlen($_POST['password']) > 0) {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        }

        // admin
        if (isset($_POST['admin'])) {
            $user->admin = $_POST['admin'];
        } else {
            $user->admin = "N";
        }

        // group admin
        if (strlen($user->user_group) > 0 AND isset($_POST['group_admin'])) {
            $user->group_admin = $_POST['group_admin'];
        } else {
            $user->group_admin = "N";
        }

        $user->save();

        $response['status'] = "SUCCESS";
        $response['user_id'] = $user->id;
    } catch (Exception $e) {
        $response['status'] = "ERROR";
        $response['message'] = $e->getMessage();
        $repsonse['object'] = $e;
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>
