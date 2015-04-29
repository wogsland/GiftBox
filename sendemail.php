<?php
include_once 'mail.php';
//For Testing
//sendMail( "founder@givetoken.com", "test email", "does this work?", "test@example.com" );

//Part to be added in once mail function is working again
//$from = $_POST_['name'] . ' <' . $_POST['email'] . '>';
//sendMail( "founder@givetoken.com", $_POST['subject'], $_POST['message'], $from);

//This part is the response back to the AJAX object
// need to tell the ajax request that i am responding back with JSON
header( 'Content-Type: application/json' );
// TODO: can we detect if sendMail() fails?
echo json_encode(array('status' => 'SUCCESS'));
?>
