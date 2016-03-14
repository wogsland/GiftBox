<?php
use \Sizzle\{
    RecruitingToken,
    User,
    UserMilestone
};

$user_id = (int) ($_GET['uid'] ?? 0);
$key = escape_string($_GET['key'] ?? '');
$_SESSION['activation_key'] = $key;
$type = strtolower($_GET['type'] ?? '');

// verify user exists
try {
    $rows_affected = update("UPDATE user
                             SET activation_key = NULL
                             WHERE id = '$user_id'
                             AND activation_key = '$key'
                             LIMIT 1");
    if ($rows_affected != 1) {
        throw new Exception('Update failed');
    }
    $UserMilestone = new UserMilestone($user_id, 'Confirm Email');
    $user = new User($user_id);
    $_SESSION['email'] = $user->email_address;
} catch (Exception $e) {
    $type = 'fail';
}

switch ($type) {
    case 'emailtoken':
    // set session variable of user token
    $tokens = RecruitingToken::getUserTokens($user_id);
    $_SESSION['first_token'] = $tokens[0]->long_id;
    $message = 'Please create a password to view your token.';
    case 'nopassword':
    // show create password page
    $message = $message ?? 'Please set a password before logging in.';
    require_once __DIR__.'/password_set.php';
    //echo 'signup with passwrod here';
    //print_r($_SESSION);
    break;
    case '':
    $_SESSION['user_id'] = $user->getId();
    $_SESSION['admin'] = $user->admin;
    $_SESSION['app_root'] = '/';
    $_SESSION['app_url'] = APP_URL;
    $_SESSION['email'] = $user->email_address;
    $_SESSION['stripe_id'] = $user->stripe_id;
    $UserMilestone = new UserMilestone($user->getId(), 'Log In');
    default:
    header('Location: '.'/'.'?action=login');
}
