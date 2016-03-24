<?php
use \Sizzle\Database\{
    EmailCredential,
    EmailList,
    EmailListEmail,
    EmailSent,
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken
};

$success = 'false';
$data = '';
if (isset($_SESSION['user_id'], $_SESSION['email'])) {
    // escape params & check if all required params set
    $params = [
        'token_id',
        'email_list_id',
        'message',
        'email_credential_id'
    ];
    $allSet = true;
    foreach ($params as $param) {
        $$param = $_POST[$param] ?? null;
        $allSet = $allSet && isset($$param);
    }
    if (!$allSet) {
        $data['errors'][] = 'Missing required parameter(s).';
    }

    // check credentials - must exist & belong to logged in user
    $EmailCredential = new EmailCredential($email_credential_id);
    if (!isset($EmailCredential->user_id)
        || $_SESSION['user_id'] != $EmailCredential->user_id
    ) {
        $data['errors'][] = 'Invalid credentials provided.';
    }

    // check list - must exist & belong to logged in user
    $EmailList = new EmailList($email_list_id);
    if (!isset($EmailList->user_id)
        || $_SESSION['user_id'] != $EmailList->user_id
    ) {
        $data['errors'][] = 'Invalid list provided.';
    }

    // check token - must exist & belong to logged in user
    $RecruitingToken = new RecruitingToken($token_id, 'long_id');
    if (!isset($RecruitingToken->user_id)
        || $_SESSION['user_id'] != $RecruitingToken->user_id
    ) {
        $data['errors'][] = 'Invalid token provided.';
    } else {
        $RecruitingCompany = new RecruitingCompany($RecruitingToken->recruiting_company_id);
    }

    if (!isset($data['errors'])) {
        $emails = (new EmailListEmail())->getByEmailListId($email_list_id);
        //print_r($emails);die;
        foreach ($emails as $address) {
            /// instantiate mailer
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
            //$mail->SMTPDebug = 3; // 2 for verbose debug output
            $mail->Port = $EmailCredential->smtp_port;

            $requiredParams = [
                'subject',
                'body',
                'address',
                'email_credential_id'
            ];

            $mail->setFrom($EmailCredential->username); // This from email is ignored by gmail, but name isn't
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
            $mail->Subject = $RecruitingCompany->name . ' ' . $RecruitingToken->job_title;
            $email_message = file_get_contents(__DIR__.'/../../../email_templates/recruiting_token.inline.html');
            $email_message = str_replace('{{message}}', ($message ?? ''), $email_message);
            $link = APP_URL.'token/recruiting/'.$token_id;
            $email_message = str_replace('{{link}}', $link, $email_message);
            $email_message = str_replace('{{job_title}}', $RecruitingToken->job_title, $email_message);
            $tracking = APP_URL."/track/open?t=3&e=$address&l=$token_id";
            $email_message = str_replace('{{tracking_link}}', $tracking, $email_message);
            $images = (new RecruitingCompanyImage())->getByRecruitingTokenLongId($token_id);
            if (isset($images[0]['file_name'])) {
                $image = '<img src="'.APP_URL.'uploads/'.$images[0]['file_name'].'" width=200 />';
            } else {
                $image = '';
            }
            $email_message = str_replace('{{image}}', $image, $email_message);
            $mail->Body = $email_message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // attempt to send
            if (!$mail->send()) {
                //print_r($mail);
                $data['error'] = $mail->ErrorInfo;
            } else {
                $success = 'true';
            }

            // record result
            $detailsToRecord['to'] = $address;
            $detailsToRecord['from'] = $EmailCredential->username;
            $detailsToRecord['subject'] = $mail->Subject;
            $detailsToRecord['body'] = $mail->Body;
            $detailsToRecord['email_credential_id'] = $email_credential_id;
            $detailsToRecord['success'] = 'true' == $success ? 'Yes' : 'No';
            (new EmailSent())->create($detailsToRecord);
        }
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
