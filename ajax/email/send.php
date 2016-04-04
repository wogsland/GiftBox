<?php
use \Sizzle\Database\{
    EmailCredential,
    EmailSent
};

$success = 'false';
$data = '';
if (logged_in()) {
    // escape params
    $params = [
        'subject',
        'body',
        'address',
        'replyTo',
        'email_credential_id',
        'cc',
        'bcc'
    ];
    foreach ($params as $param) {
        $$param = $_POST[$param] ?? null;
    }

    // check if all required params set
    $requiredParams = [
        'subject',
        'body',
        'address',
        'email_credential_id'
    ];
    $allSet = true;
    foreach ($requiredParams as $param) {
        $allSet = $allSet && isset($$param);
    }
    if ($allSet) {

        // check credentials - must exist & belong to logged in user
        $EmailCredential = new EmailCredential($email_credential_id);
        if (isset($EmailCredential->user_id)
            && $_SESSION['user_id'] == $EmailCredential->user_id
        ) {
            // instantiate mailer
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->isHTML(true);
            //$mail->SMTPDebug = 3; // Enable verbose debug output

            /*
            If testing locally with Gmail, you'll need to turn this on
            https://www.google.com/settings/security/lesssecureapps
            */

            // add credentials
            $mail->Host = $EmailCredential->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $EmailCredential->username;
            $mail->Password = $EmailCredential->password;
            $mail->SMTPSecure = 'tls'; // tle or ssl
            $mail->Port = $EmailCredential->smtp_port;

            $mail->setFrom($EmailCredential->username, 'Give Token'); // This from email is ignored by gmail, but name isn't
            $mail->addAddress($address);
            if (isset($replyTo)) {
                $mail->addReplyTo($replyTo);
            }
            if (isset($cc)) {
                $mail->addCC($cc);
            }
            if (isset($bcc)) {
                $mail->addCC($bcc);
            }

            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if (!$mail->send()) {
                $data['error'] = $mail->ErrorInfo;
            } else {
                $success = 'true';
            }
        } else {
            $data['error'] = 'Invalid credentials provided.';
        }
    } else {
        $data['error'] = 'Missing required parameter(s).';
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
