<?php
use \google\appengine\api\mail\Message;

include_once 'config.php';
include_once 'mail.php';

try {
	$email_message = " To activate your GiveToken account, please click on this link:\n\n";
	sendMail('john_hall@corridor-inc.com', 'GiveToken Registration Confirmation', $email_message, $sender_email);
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
}
?>
