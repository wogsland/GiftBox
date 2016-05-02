<?php
use \Sizzle\Bacon\Database\User;

date_default_timezone_set('America/Chicago');

$success = 'false';
$data = '';

// check for form spamming
$today = date('Y-m-d');
if (isset($_SESSION['code_reset_attempt'], $_SESSION['code_reset_attempt']['date'], $_SESSION['code_reset_attempt']['tries'])) {
    if ($_SESSION['code_reset_attempt']['date'] == $today) {
        if ($_SESSION['code_reset_attempt']['tries'] >= 3) {
            $data = 'Too many tries. Come back ma&ntilde;ana.';
        }
        $_SESSION['code_reset_attempt']['tries']++;
    } else {
        $_SESSION['code_reset_attempt']['date'] = $today;
        $_SESSION['code_reset_attempt']['tries'] = 1;
    }
} else {
    $_SESSION['code_reset_attempt']['date'] = $today;
    $_SESSION['code_reset_attempt']['tries'] = 1;
}

// try email
if (isset($_POST['reset_code'], $_POST['password'])
    && $_SESSION['code_reset_attempt']['tries'] <= 3
) {
    // find user corresponding to email
    $user = (new User())->fetch($_POST['reset_code'], 'reset_code');

    // set password if user exists
    if (isset($user->email_address)) {
        $user->reset_code = '';
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->save();
        $success = 'true';
    } else {
        $data = 'This code is invalid.';
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
