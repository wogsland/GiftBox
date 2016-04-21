<?php
use \Sizzle\Bacon\Database\User;
use \Sizzle\Service\MandrillEmail;

date_default_timezone_set('America/Chicago');

$success = 'false';
$data = '';
$user_id = (int) $_POST['id'];

if ($user_id > 0) {

    $user = new User($user_id);
    if (isset($user->activation_key) && '' != $user->activation_key) {
        $link = APP_URL . 'activate?uid=' . $user_id . "&key=$user->activation_key";
        if (!isset($user->password) || '' == $user->password) {
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
        $success = 'true';
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
