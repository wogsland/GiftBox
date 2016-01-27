<?php
use \Sizzle\{
    EventLogger,
    User,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

$user = null;
$event_type = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to log in at this time.";
$response['app_root'] = '/';

$email = $_POST['login_email'];
$login_type = $_POST['login_type'];
if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $password = null;
}

if (User::exists($email)) {
    $user = User::fetch($email);
    $expires = $user->active_until ?? date('Y-m-d');
    $DateTime1 = new \DateTime($expires);
    $DateTime2 = new \DateTime(date('Y-m-d'));
    if (0 <= date_diff($DateTime2, $DateTime1)->format('%R%a')) {
        if ($login_type == 'FACEBOOK') {
            $event_type = EventLogger::LOGIN_USING_FACEBOOK;
            $response['status'] = 'SUCCESS';
            $response['message'] = "Log in with Facebook successful.";
        } else if ($login_type == 'EMAIL') {
            if (!$user->password) {
                $response['status'] = "ERROR";
                $response['message'] = "This account was created using Facebook.<br>Please use the Log In With FaceBook button.";
            } else if (!password_verify($password, $user->password)) {
                $response['status'] = "ERROR";
                $response['message'] = 'The password you entered is incorrect.';
            } else {
                if ($user->activation_key) {
                    $response['status'] = "ERROR";
                    $response['message'] = $user->activation_key;
                } else {
                    $event_type = EventLogger::LOGIN_USING_EMAIL;
                    $response['status'] = 'SUCCESS';
                    $response['message'] = "Log in with email successful.";
                }
            }
        }
        if ($response['status'] == 'SUCCESS') {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['admin'] = $user->admin;
            $_SESSION['login_type'] = $login_type;
            $_SESSION['app_root'] = '/';
            $_SESSION['app_url'] = APP_URL;
            $_SESSION['level'] = $user->level;
            $_SESSION['email'] = $email;
            $_SESSION['stripe_id'] = $user->stripe_id;
            $event = new EventLogger($user->getId(), $event_type);
            $event->log();
            $UserMilestone = new UserMilestone($user->getId(), 'Log In');
        }
    } else {
        $response['status'] = "ERROR";
        $response['message'] = "This account is no longer active.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "The email address \"".$email."\" does not belong to any S!zzle account. Please use the signup button to register!";
}

header('Content-Type: application/json');
echo json_encode($response);
