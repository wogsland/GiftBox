<?php
include_once 'mail.php';

$from = $_POST['name'] . ' <' . $_POST['email'] . '>';
sendMail( "founder@givetoken", $_POST['subject'], $_POST['message'], $from);

//This part is the response back to the AJAX object
// need to tell the ajax request that i am responding back with JSON
header( 'Content-Type: application/json' );
// TODO: can we detect if sendMail() fails?
echo json_encode(array('status' => 'SUCCESS'));
?>