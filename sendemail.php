<?php
require_once __DIR__.'/mail.php';

if (isset($_POST['email'], $_POST['message'])) {
    $from = $_POST['name'] . ' <' . $_POST['email'] . '>';
    sendMail("founder@givetoken", $_POST['subject'], $_POST['message'], $from);

    //This part is the response back to the AJAX object
    // need to tell the ajax request that i am responding back with JSON
    header('Content-Type: application/json');
    // TODO: can we detect if sendMail() fails?
    echo json_encode(array('status' => 'SUCCESS'));
} else {
    echo json_encode(array('status' => 'ERROR'));
}
?>
