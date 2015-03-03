<?php
include_once 'config.php';
include_once 'mail.php';

// Send the email
sendMail(
	$message_recipient_email, 
	$_POST['subject'], 
	"Name: ".$_POST['name']."
	Message: ".$_POST['message'],
	$_POST['email']);