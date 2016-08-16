<?php
use Sizzle\Bacon\Database\{
    ExperimentRecruitingTokenResponse,
    FullcontactPerson,
    RecruitingTokenResponse,
    RecruitingToken
};
use Sizzle\Bacon\Service\{
    FullContact,
    MandrillEmail
};

// collect info from url
$recruiting_token_id = $endpoint_parts[4] ?? '';
$email = urldecode($endpoint_parts[5] ?? '');
$response = ucfirst(strtolower($endpoint_parts[6] ?? ''));
$name = urldecode($endpoint_parts[7] ?? '');
$cookie = $_COOKIE['visitor'] ?? '';

$success = 'false';
$data = '';
$recruiting_token_response = new RecruitingTokenResponse();
$id = $recruiting_token_response->create($recruiting_token_id, $email, $response, $name, $cookie);
if ($id > 0) {
    $success = 'true';
    $data = array('id'=>$id);
}
$recruiting_token = new RecruitingToken($recruiting_token_id, 'long_id');

// record any experiments
if(isset($_SESSION['experiments'], $_SESSION['experiments'][$recruiting_token->id])) {
    foreach ($_SESSION['experiments'][$recruiting_token->id] as $experiment) {
        (new ExperimentRecruitingTokenResponse())->create(
            $experiment['id'],
            $experiment['version'],
            $id
        );
    }
}

// hit the FullContact Person API to get information
$extra_details = '';
if ('' != $email) {
    $fullcontact = (new FullContact())->person($email, $id);
    $name = '' == $name ? ($fullcontact->contactInfo->fullName ?? '') : $name;

    //process demographics
    if (isset($fullcontact->demographics)) {
        if (isset($fullcontact->demographics->gender)) {
            $extra_details .= '<p><b>Gender:</b> '.$fullcontact->demographics->gender.'</p>';
        }
        if (isset($fullcontact->demographics->locationGeneral)
            || isset($fullcontact->demographics->locationDeduced)
        ) {
            $location = $fullcontact->demographics->locationGeneral ?? '';
            if ('' == $location) {
                $location = $fullcontact->demographics->locationDeduced->deducedLocation ?? '';
            }
            if ('' != $location) {
                $extra_details .= '<p><b>Location:</b> '.$location.'</p>';
            }
        }
    }

    //process organizations
    if (isset($fullcontact->organizations)) {
        $extra_details .= '<b>Organizations:</b><br>';
        foreach ($fullcontact->organizations as $fcOrganization) {
            $extra_details .= '<p>';
            $extra_details .= ($fcOrganization->title ?? '').' ';
            $extra_details .= isset($fcOrganization->title, $fcOrganization->name) ? 'at ' : '';
            $extra_details .= ($fcOrganization->name ?? '').' ';
            if (isset($fcOrganization->startDate)
                || isset($fcOrganization->endDate)
                || isset($fcOrganization->current)
            ){
                $extra_details .= '(';
                $extra_details .= $fcOrganization->startDate ?? '?';
                $extra_details .= ' - ';
                $extra_details .= $fcOrganization->endDate ?? ($fcOrganization->current ? 'Present' : '?');
                $extra_details .= ')';
            }
            $extra_details .= '</p>';
        }
    }

    //process websites
    if (isset($fullcontact->contactInfo->websites)) {
        $extra_details .= '<b>Websites:</b><br><p>';
        foreach ($fullcontact->contactInfo->websites as $website) {
            $extra_details .= '<a href="'.$website->url.'">';
            $extra_details .= $website->url;
            $extra_details .= '</a><br>';
        }
        $extra_details .= '</p>';
    }

    // process fullcontact social media & photos
    if (isset($fullcontact->socialProfiles) || isset($fullcontact->photos)) {
        $extra_details .= '<b>Social Media:</b><br>';

        if (isset($fullcontact->photos)) {
            // first list social media with photos
            foreach ($fullcontact->photos as $photo) {
                if (isset($photo->url)) {
                    $photoText = $photo->type ?? '';
                    if (isset($fullcontact->socialProfiles)) {
                        foreach ($fullcontact->socialProfiles as &$socialProfile) {
                            if (isset($socialProfile->type, $socialProfile->url)
                                && ($photo->type ?? '') == $socialProfile->type
                            ) {
                                // jackpot
                                $photoText = '<a href="'.$socialProfile->url.'">';
                                $photoText .= $socialProfile->type.'</a>';
                                if (isset($socialProfile->bio)) {
                                    $photoText .= '<br>bio: '.$socialProfile->bio;
                                }
                                $socialProfile->alreadyUsed = true;
                            }
                        }
                    }
                    $extra_details .= '<p>';
                    $extra_details .= '<img src="'.$photo->url.'">';
                    $extra_details .= '<br>'.$photoText;
                    $extra_details .= '</p>';
                }
            }
        }

        // social media without photos
        if (isset($fullcontact->socialProfiles)) {
            foreach ($fullcontact->socialProfiles as $socialProfile) {
                if (!isset($socialProfile->alreadyUsed)) {
                    $extra_details .= '<p>';
                    $extra_details .= '<a href="'.$socialProfile->url.'">';
                    $extra_details .= $socialProfile->type.'</a>';
                    if (isset($socialProfile->bio)) {
                        $extra_details .= '<br>bio: '.$socialProfile->bio;
                    }
                    $extra_details .= '</p>';
                }
            }
        }
    }
}
$otherMessage = "<p>We also gathered some additional information on your candidate...</p>";
$extra_details = '' != $extra_details ? $otherMessage.$extra_details : '';

$user = $recruiting_token->getUser();
$company = $recruiting_token->getCompany();
if (is_object($user) && isset($user->receive_token_notifications) && strcmp($user->receive_token_notifications, 'Y') == 0) {
    $company_name = empty($company->name) ? "No Company Name" : $company->name;
    $email_message = file_get_contents(__DIR__.'/../../email_templates/token_response_notification.inline.html');
    $email_message = str_replace('{{company_name}}', $company_name, $email_message);
    $email_message = str_replace('{{job_title}}', $recruiting_token->job_title, $email_message);
    $email_message = str_replace('{{email_address}}', $name.' '.$email, $email_message);
    $email_message = str_replace('{{response}}', $response, $email_message);
    $email_message = str_replace('{{extra_details}}', $extra_details, $email_message);
    $mandrill = new MandrillEmail();
    $mandrill->send(
        array(
            'to'=>array(array('email'=>$user->email_address)),
            'from_email'=>'notifications@GoSizzle.io',
            'from_name'=>'S!zzle',
            'subject'=>'S!zzle Token Response Notification',
            'html'=>$email_message
        )
    );
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
