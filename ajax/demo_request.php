<?php
use Sizzle\Bacon\Database\{
    Support
};
use Sizzle\Bacon\Service\MandrillEmail;

$status = 'ERROR';
if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $vars = array('email');
    foreach ($vars as $var) {
        $$var = $_POST[$var] ?? '';
    }
    $subject = "New demo request from {$email}";
    if (ENVIRONMENT != 'production') {
        $to = TEST_EMAIL;
    } else {
        $to = 'sales@gosizzle.io';
    }
    $mandrill = new MandrillEmail();
    $mandrill->send(
        array(
            'to'=>array(array('email'=>$to)),
            'from_email'=>'demo.request@gosizzle.io',
            'from_name'=>'S!zzle Demo Request',
            'subject'=>$subject,
            'html'=>$subject,
            'headers'=>array('Reply-To'=>$email)
        )
    );
    $status = 'SUCCESS';
    //(new Support())->create($email, $message);
}
header('Content-Type: application/json');
echo json_encode(array('status' => $status));

?>
