<?php
require_once 'config.php';
require_once 'mail.php';

// Send the email
sendMail(
    $message_recipient_email, 
    $_POST['subject'], 
    "Name: &nbsp;".$_POST['name']."<br><br>".
    "Email: &nbsp;".$_POST['email']."<br><br>".
    "Server: &nbsp;".$server."<br><br>".
    "Message: &nbsp;".$_POST['message'],
    $sender_email
);