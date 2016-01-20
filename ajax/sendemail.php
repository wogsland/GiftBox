<?php
use \Sizzle\Service\GoogleMail;

$status = 'ERROR';
header('Content-Type: application/json');
if (isset($_POST['email'], $_POST['message'])
&& filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    $vars = array('email', 'message', 'name', 'subject');
    foreach ($vars as $var) {
        $$var = isset($_POST[$var]) ? $_POST[$var] : '';
    }
    $from = $name . ' (' . $email . ')';
    $subject = '' == $subject ? 'Message from '.$from : $subject;
    $message .= "\r\n\r\n - $from";
    if (ENVIRONMENT != 'production') {
        $to = 'bwogsland@gosizzle.io';
    } else {
        $to = 'contact@gosizzle.io';
    }
    $GoogleMail = new GoogleMail();
    if ($GoogleMail->sendMail($to, $subject, $message, 'founder@givetoken.com')) {
        $status = 'SUCCESS';
    }
}
echo json_encode(array('status' => $status));

?>
