<?php
include_once 'config.php';
include_once 'mail.php';

// Send the email
sendMail(
	$message_recipient_email, 
	$_POST['subject'], 
	$_POST['message'],
	$_POST['name'] . ' <' . $_POST['email'] . '>');