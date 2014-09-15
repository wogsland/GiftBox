<?php
include_once 'eventLogger.class.php';
include_once 'config.php';
include_once 'mail.php';

$email_address = $_POST["email"];
$preview_link = $_POST["preview-link"];
$event = SEND_GIFTBOX;
$user_id = $_COOKIE["user_id"];

$event = new eventLogger($user_id, $event);
$event->log();

// Send the email
$message = '<a href="'.$preview_link.'">Click here to open your Token!</a>';
sendMail($email_address, 'You have a Token to open!!!', $message, $sender_email);
?>