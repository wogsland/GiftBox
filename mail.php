<?php
use google\appengine\api\mail\Message;

if ($google_app_engine) {
    include_once 'google/appengine/api/mail/Message.php';
}

function sendMail($to, $subject, $message, $from)
{
    global $google_app_engine;
    if ($google_app_engine) {
        $mail_options = [
            "sender" => $from,
            "to" => $to,
            "subject" => $subject,
            "htmlBody" => $message
        ];
        $message = new Message($mail_options);
        $message->send();
    }
}
