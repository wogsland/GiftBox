<?php
include_once 'eventLogger.class.php';
include_once 'config.php';

$email_address = $_POST["email"];
$preview_link = $_POST["preview-link"];
$event = SEND_GIFTBOX;
$user_id = $_COOKIE["user_id"];

$event = new eventLogger($user_id, $event);
$event->log();

// Send the email
$message = "To open your Giftbox, please click on this link:\n\n".$preview_link;
mail($email_address, 'You have a Giftbox to open!!!', $message, 'From:'. $sender_email);
?>