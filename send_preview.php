<?php
include_once 'eventLogger.class.php';
include_once 'config.php';

$message = "Unable to email the giftbox at this time.";
$email_address = $_GET['email'];
$preview_id = $_GET['preview_id'];
$event = SEND_GIFTBOX;
$user_id = $_COOKIE["user_id"];

$event = new eventLogger($user_id, $event);
$event->log();

// Send the email
$message = "To open your Giftbox, please click on this link:\n\n";
$message .= $app_url.'/preview.php?gbpid=$preview_id';
mail($email_address, 'You have a Giftbox to open!!!', $message, 'From:'. $sender_email);
$message = 'SUCCESS';

$json = '{"message":"'.$message.'"}';

echo $json;
?>