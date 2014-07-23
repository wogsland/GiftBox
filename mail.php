<?php
include_once 'config.php';
if ($use_google_mail) {
	require_once 'google/appengine/api/mail/Message.php';
}

function sendMail($to, $subject, $message, $from) {
	global $use_google_mail;
	if ($use_google_mail) {
		$mail_options = [
			"sender" => $from,
			"to" => $to,
			"subject" => $subject,
			"htmlBody" => $message
		];
		$message = new Message($mail_options);
		$message->send();	
	} else {
		mail($to, $subject, $message, $from);
	}
}
?>