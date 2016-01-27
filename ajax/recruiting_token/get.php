<?php
use \Sizzle\{
    RecruitingCompany,
    RecruitingToken,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

// collect id
$id = escape_string($endpoint_parts[4] ?? '');

$success = 'false';
$data = '';
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $success = 'true';
        if (isset($token->recruiting_company_id)
            && (int) $token->recruiting_company_id > 0
        ) {
            $company = new RecruitingCompany($token->recruiting_company_id);
            if (isset($company->id)) {
                $data = get_object_vars($token);
                $data['company'] = $company->name;
                $data['company_website'] = $company->website;
                $data['company_values'] = $company->values;
                $data['company_facebook'] = $company->facebook;
                $data['company_linkedin'] = $company->linkedin;
                $data['company_youtube'] = $company->youtube;
                $data['company_twitter'] = $company->twitter;
                $data['company_google_plus'] = $company->google_plus;
                $data['company_pinterest'] = $company->pinterest;
                $data = (object) $data;
            } else {
                $data = $token;
            }
        } else {
            $data = $token;
        }
        if (!logged_in()) {
            $UserMilestone = new UserMilestone($token->user_id, 'Token View By Non-User');
        }
    }
}
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data);
echo json_encode($result);
