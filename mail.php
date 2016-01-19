<?php
use google\appengine\api\mail\Message;

if (GOOGLE_APP_ENGINE) {
    include_once 'google/appengine/api/mail/Message.php';
}

function sendMail($to, $subject, $message, $from)
{
    if (GOOGLE_APP_ENGINE) {
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
