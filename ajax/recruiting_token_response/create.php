<?php
use Sizzle\RecruitingTokenResponse;
use Sizzle\RecruitingToken;

// collect info from url
$recruiting_token_id = escape_string($endpoint_parts[4] ?? '');
$email = escape_string($endpoint_parts[5] ?? '');
$email = urldecode($email);
$response = escape_string($endpoint_parts[6] ?? '');
$response = ucfirst(strtolower($response));
$cookie = escape_string($_COOKIE['visitor'] ?? '');

$success = 'false';
$data = '';
$RecruitingTokenResponse = new RecruitingTokenResponse();
$id = $RecruitingTokenResponse->create($recruiting_token_id, $email, $response, $cookie);
if ($id > 0) {
    $success = 'true';
    $data = array('id'=>$id);
}
$user = (new RecruitingToken($recruiting_token_id, 'long_id'))->getUser();
if (strcmp($user->receive_token_notifications, 'Y') == 0) {
    $email_message = file_get_contents(__DIR__.'/../../email_templates/token_response_notification.inline.html');
    $email_message = str_replace('{{email_address}}', $email, $email_message);
    $email_message = str_replace('{{response}}', $response, $email_message);
    $mandrill = new Mandrill(MANDRILL_API_KEY);
    $mandrill->messages->send(array(
      'to'=>array(array('email'=>$user->email_address)),
      'from_email'=>'notifications@gosizzle.io',
      'from_name'=>'S!zzle',
      'subject'=>'S!zzle Token Response Notification',
      'html'=>$email_message
    ));
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
