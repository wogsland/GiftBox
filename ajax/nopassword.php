<?php
use \Sizzle\Database\{
    User,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

$success = 'false';
$data = '';

// check form came in on proper path
if (isset($_SESSION['activation_key'], $_POST['activation_key'])
    && $_POST['activation_key'] == $_SESSION['activation_key']
) {
    unset($_SESSION['activation_key']);
    $email = escape_string($_SESSION['email']);
    $password = escape_string($_POST['password']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // find user corresponding to email
        $user = User::fetch($email);

        if (isset($user->email_address)) {
            // set password if user exists
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->save();
            $success = 'true';

            // get url string
            if (isset($_SESSION['first_token'])) {
                $data['url'] = '/token/recruiting/'.$_SESSION['first_token'];
                unset($_SESSION['first_token']);
            } else {
                $data['url'] = '/profile';
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['admin'] = $user->admin;
                $_SESSION['app_root'] = '/';
                $_SESSION['app_url'] = APP_URL;
                $_SESSION['email'] = $user->email_address;
                $_SESSION['stripe_id'] = $user->stripe_id;
                $UserMilestone = new UserMilestone($user->getId(), 'Log In');
            }
        }
    }
}

// try email
if (isset($_POST['reset_code'], $_POST['password'])
    && $_SESSION['code_reset_attempt']['tries'] <= 3
) {
    $reset_code = escape_string($_POST['reset_code']);
    $password = escape_string($_POST['password']);

    // find user corresponding to email
    $user = User::fetch($reset_code, 'reset_code');

    // set password if user exists
    if (isset($user->email_address)) {
        $user->reset_code = '';
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->save();
        $success = 'true';
    } else {
        $data = 'This code is invalid.';
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
