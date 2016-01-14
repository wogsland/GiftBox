<?php
use \GiveToken\EventLogger;
use \GiveToken\Service\GoogleMail;
use \GiveToken\UserMilestone;
use \GiveToken\User;

date_default_timezone_set('America/Chicago');

$event = null;
$user_id = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to register at this time.";
$response['app_root'] = $app_root;

$user = new User();
$user->email_address = escape_string($_POST['signup_email']);
$user->first_name = escape_string($_POST['first_name']);
$user->last_name = escape_string($_POST['last_name']);
if (isset($_POST['signup_password'])) {
    $user->password = escape_string($_POST['signup_password']);
} else {
    $user->password = null;
}
$user->level = 1;
$types = ['EMAIL', 'FACEBOOK'];
if (isset($_POST['reg_type']) && in_array($_POST['reg_type'], $types)) {
    $reg_type = $_POST['reg_type'];
} else {
    $reg_type = 'EMAIL';
}

// Make sure the email address is available:
if (User::exists($user->email_address)) {
    $response['status'] = "ERROR";
    $response['message'] = "The email address $user->email_address has already been registered.";
} else {
    if ($reg_type == 'EMAIL') {
        $user->activation_key = md5(uniqid(mt_rand(), false));
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $event = EventLogger::REGISTER_USING_EMAIL;
    } else if ($reg_type == 'FACEBOOK') {
        $user->activation_key = null;
        $user->password = null;
        $event = EventLogger::REGISTER_USING_FACEBOOK;
    }
    $user->save();
    $event = new EventLogger($user->getId(), $event);
    $event->log();

    if ($reg_type == 'EMAIL') {
        // Send the email
        $link = $app_url . 'activate?uid=' . $user->getId() . "&key=$user->activation_key";
        $email_message = file_get_contents(__DIR__.'/../email_templates/signup_email.inline.html');
        $email_message = str_replace('{{link}}', $link, $email_message);
        $sender_email = 'GiveToken <founder@givetoken.com>';
        $GoogleMail = new GoogleMail();
        $GoogleMail->sendMail(
            $user->email_address,
            'GiveToken Signup Confirmation',
            $email_message,
            $sender_email
        );
    }
    $response['status'] = "SUCCESS";
    $response['message'] = "{$user->email_address} successsfully registered.";
    $UserMilestone = new UserMilestone($user->getId(), 'Signup');
}

header('Content-Type: application/json');
echo json_encode($response);
