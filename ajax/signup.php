<?php
use \Sizzle\Bacon\{
    Database\User,
    Database\UserMilestone,
    Service\PipedriveClient,
    Service\MandrillEmail
};

date_default_timezone_set('America/Chicago');

$user_id = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to register at this time.";
$response['app_root'] = '/';

$vars = array(
    'signup_email',
    'first_name',
    'last_name',
    'signup_password',
    'reg_type'
);
foreach ($vars as $var) {
    $$var = $_POST[$var] ?? '';
}

if (filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {

    $user = new User();
    $user->email_address = $signup_email;
    $user->first_name = $first_name;
    $user->last_name = $last_name;
    if ('' != $signup_password) {
        $user->password = $signup_password;
    } else {
        $user->password = null;
    }
    $types = ['EMAIL', 'FACEBOOK'];
    if (!in_array($reg_type, $types)) {
        $reg_type = 'EMAIL';
    }

    // Make sure the email address is available:
    if ((new User())->exists($user->email_address)) {
        $response['status'] = "ERROR";
        $response['message'] = "The email address $user->email_address has already been registered.";
    } else {
        if ($reg_type == 'EMAIL') {
            $user->activation_key = md5(uniqid(mt_rand(), false));
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        } else if ($reg_type == 'FACEBOOK') {
            $user->activation_key = null;
            $user->password = null;
        }
        $user->save();

        if ($reg_type == 'EMAIL') {
            // Send the email
            $link = APP_URL . 'activate?uid=' . $user->id . "&key=$user->activation_key";
            if ('' == $signup_password) {
                $link .= '&type=nopassword';
            }
            $email_message = file_get_contents(__DIR__.'/../email_templates/signup_email.inline.html');
            $email_message = str_replace('{{link}}', $link, $email_message);
            $email_message = str_replace('{{email}}', $user->email_address, $email_message);
            $mandrill = new MandrillEmail();
            $mandrill->send(
                array(
                    'to'=>array(array('email'=>$user->email_address)),
                    'from_email'=>'welcome@gosizzle.io',
                    'from_name'=>'S!zzle',
                    'subject'=>'S!zzle Signup Confirmation',
                    'html'=>$email_message
                )
            );
        }
        $response['status'] = "SUCCESS";
        $response['message'] = "{$user->email_address} successsfully registered.";
        $UserMilestone = new UserMilestone($user->id, 'Signup');

        // Create Free trial in Pipedrive
        $pipedriveClient = new PipedriveClient(PIPEDRIVE_API_TOKEN);
        $pipedriveClient->createFreeTrial($user);
    }
}
header('Content-Type: application/json');
echo json_encode($response);
