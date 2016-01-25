<?php
$status = 'ERROR';
if (isset($_POST['email'], $_POST['message'])
&& filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    $vars = array('email', 'message', 'name', 'subject');
    foreach ($vars as $var) {
        $$var = isset($_POST[$var]) ? $_POST[$var] : '';
    }
    $from = $name . ' (' . $email . ')';
    $subject = '' == $subject ? 'Message from '.$from : $subject;
    $message .= "\r\n\r\n - $from";
    if (ENVIRONMENT != 'production') {
        $to = 'bwogsland@gosizzle.io';
    } else {
        $to = 'contact@gosizzle.io';
    }
    $mandrill = new Mandrill(MANDRILL_API_KEY);
    $mandrill->messages->send(array(
      'to'=>array(array('email'=>$to)),
      'from_email'=>'contact@gosizzle.io',
      'from_name'=>'S!zzle',
      'subject'=>$subject,
      'html'=>$message
    ));
    $status = 'SUCCESS';
}
header('Content-Type: application/json');
echo json_encode(array('status' => $status));

?>
