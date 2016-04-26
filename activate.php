<?php
use \Sizzle\Bacon\Database\{
    RecruitingToken,
    User,
    UserMilestone
};

$type = strtolower($_GET['type'] ?? '');

// activate user
$user = new User($_GET['uid'] ?? 0);
if (isset($user->email_address) && $user->activate($_GET['key'] ?? '')) {
    $_SESSION['activation_key'] = $_GET['key'];
    $_SESSION['email'] = $user->email_address;
} else {
    $type = 'fail';
}

switch ($type) {
    case 'emailtoken':
    // set session variable of user token
    $tokens = (new RecruitingToken())->getUserTokens($user->id);
    $_SESSION['first_token'] = $tokens[0]->long_id;
    $message = 'Please create a password to view your token.';
    case 'nopassword':
    // show create password page
    $message = $message ?? 'Please set a password before logging in.';
    require_once __DIR__.'/password_set.php';
    break;
    case '':
    // web only activation where user's already set up password
    $_SESSION['user_id'] = $user->id;
    $_SESSION['admin'] = $user->admin;
    $_SESSION['app_root'] = '/';
    $_SESSION['app_url'] = APP_URL;
    $_SESSION['email'] = $user->email_address;
    $_SESSION['stripe_id'] = $user->stripe_id;
    $UserMilestone = new UserMilestone($user->id, 'Log In');
    default:
    header('Location: '.'/'.'?action=login');
}
