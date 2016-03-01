<?php

$success = 'false';
$data = '';
$fileName = escape_string($_POST['fileName'] ?? false);
$localPath = $_FILES['listFile']['tmp_name'] ?? false;
if ($fileName && $localPath) {
    $fileData = file_get_contents($localPath);
    $mandrill = new Mandrill(MANDRILL_API_KEY);
    $mandrill->messages->send(array(
      'to'=>array(array('email'=>'bwogsland@gosizzle.io')),
      'from_email'=>'emailsignup@gosizzle.io',
      'from_name'=>'S!zzle',
      'subject'=>'New S!zzle Email Signup',
      'html'=>$fileData
    ));
    $data = array(
        'errors'=>array(),
        'message'=>'Job Description successfully uploaded.'
    );
    $success = 'true';
  } else {
    $data = array(
        'errors'=>array(),
        'message'=>'There were errors processing your request.'
    );
    if (!$localPath) {
        $data['errors'][] = 'File is required.';
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
