<?php
include_once 'config.php';
use \google\appengine\api\mail\Message;

try {
	$email_message = " To activate your Giftbox account, please click on this link:\n\n";
	sendMail('john_hall@corridor-inc.com', 'Giftbox Registration Confirmation', $email_message, $sender_email);
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
}
?>