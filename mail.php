<?php
include_once 'config.php';
use \google\appengine\api\mail\Message;

function sendMail($to, $subject, $message, $from) {
	global $use_google_mail;
	if ($use_google_mail) {
		try
		{
		  $message = new Message();
		  $message->setSender($from);
		  $message->addTo($to);
		  $message->setSubject($subject);
		  $message->setTextBody($message);
		  $message->send();
		} catch (InvalidArgumentException $e) {
			echo $e.getMessage();
		}
	} else {
		mail($to, $subject, $message, $from);
	}
}
?>