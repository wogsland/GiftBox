<?php
use google\appengine\api\mail\Message;

include_once 'config.php';
if ($google_app_engine) {
	require_once 'google/appengine/api/mail/Message.php';
}

function sendMail($to, $subject, $message, $from) {
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
	} else {
//		mail($to, $subject, $message, "From: ".$from."\r\n"."Content-Type: text/html; charset=ISO-8859-1\r\n");
	}
}
