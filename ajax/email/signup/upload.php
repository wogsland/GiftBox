<?php
use Sizzle\Service\MandrillEmail;

$success = 'false';
$data = '';
$fileName = $_POST['fileName'] ?? false;
$email = $_POST['email'] ?? false;
$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
$localPath = $_FILES['listFile']['tmp_name'] ?? false;
if ($fileName && $localPath && $email) {
    $fileData = base64_encode(file_get_contents($localPath));
    $mandrill = new MandrillEmail();
    $message = "Robbie! There's a new email signup!<br /><br />";
    $message .= $email . " has signed up!<br /><br />";
    $message .= 'Their job description is attached.';
    $mandrill->send(
        array(
            'to'=>array(array('email'=>'token@gosizzle.io')),
            'from_email'=>'emailsignup@gosizzle.io',
            'from_name'=>'S!zzle',
            'subject'=>'New S!zzle Email Signup',
            'html'=>$message,
            'attachments' => array(
                array(
                    'content' => $fileData,
                    //'type' => "application/pdf",
                    'name' => $fileName,
                )
            )
        )
    );
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
    if (!$email) {
        $data['errors'][] = 'Valid email address is required.';
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
