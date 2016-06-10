<?php
use Sizzle\Bacon\Database\{
    RecruitingTokenResponse,
    RecruitingToken
};
use Sizzle\Bacon\Service\MandrillEmail;

// collect info from url
$recruiting_token_id = $endpoint_parts[4] ?? '';
$email = urldecode($endpoint_parts[5] ?? '');
$response = ucfirst(strtolower($endpoint_parts[6] ?? ''));
$name = ucfirst(strtolower($endpoint_parts[7] ?? ''));
$cookie = $_COOKIE['visitor'] ?? '';

$success = 'false';
$data = '';
$recruiting_token_response = new RecruitingTokenResponse();
$id = $recruiting_token_response->create($recruiting_token_id, $email, $response, $name, $cookie);
if ($id > 0) {
    $success = 'true';
    $data = array('id'=>$id);
}
$recruiting_token = new RecruitingToken($recruiting_token_id, 'long_id');
$user = $recruiting_token->getUser();
$company = $recruiting_token->getCompany();
if (is_object($user) && isset($user->receive_token_notifications) && strcmp($user->receive_token_notifications, 'Y') == 0) {
    $company_name = empty($company->name) ? "No Company Name" : $company->name;
    $email_message = file_get_contents(__DIR__.'/../../email_templates/token_response_notification.inline.html');
    $email_message = str_replace('{{company_name}}', $company_name, $email_message);
    $email_message = str_replace('{{job_title}}', $recruiting_token->job_title, $email_message);
    $email_message = str_replace('{{email_address}}', $name.' '.$email, $email_message);
    $email_message = str_replace('{{response}}', $response, $email_message);
    $mandrill = new MandrillEmail();
    $mandrill->send(
        array(
            'to'=>array(array('email'=>$user->email_address)),
            'from_email'=>'notifications@gosizzle.io',
            'from_name'=>'S!zzle',
            'subject'=>'S!zzle Token Response Notification',
            'html'=>$email_message
        )
    );
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
