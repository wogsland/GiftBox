<?php
use \GiveToken\User;

date_default_timezone_set('America/Chicago');

require_once __DIR__.'/../mail.php';

$success = 'false';
$data = '';

// check for form spamming
$today = date('Y-m-d');
if (isset($_SESSION['reset_attempt'], $_SESSION['reset_attempt']['date'], $_SESSION['reset_attempt']['tries'])) {
    if ($_SESSION['reset_attempt']['date'] == $today) {
        if ($_SESSION['reset_attempt']['tries'] >= 3) {
            $data = 'Too many tries. Come back ma&ntilde;ana.';
        }
        $_SESSION['reset_attempt']['tries']++;
    } else {
        $_SESSION['reset_attempt']['date'] = $today;
        $_SESSION['reset_attempt']['tries'] = 1;
    }
} else {
    $_SESSION['reset_attempt']['date'] = $today;
    $_SESSION['reset_attempt']['tries'] = 1;
}

// try email
if (isset($_POST['email']) && $_SESSION['reset_attempt']['tries'] <= 3) {
    $email = escape_string($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // find user corresponding to email
        $user = User::fetch($email);

        // send email if user exists
        if (isset($user->email_address)) {
            // set reset code
            $user->reset_code = substr(md5(microtime()), rand(0, 26), 20);
            $user->save();

            // send email
            $link = $app_url . 'password_reset?secret=' . $user->reset_code;
            $email_message = file_get_contents(__DIR__.'/../email_templates/password_reset.inline.html');
            $email_message = str_replace('{{link}}', $link, $email_message);
            $sender_email = 'GiveToken <founder@givetoken.com>';
            sendMail($user->email_address, 'GiveToken Password Reset', $email_message, $sender_email);
            $success = 'true';
            $data = 'Check your email.';
        } else {
            $data = 'This email does not correspond to an account.';
        }
    } else {
        $data = "The email $email is invalid.";
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
