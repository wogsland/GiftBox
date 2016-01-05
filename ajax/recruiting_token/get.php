<?php
use \GiveToken\RecruitingCompany;
use \GiveToken\RecruitingToken;

// collect id
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';

$success = 'false';
$data = '';
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $success = 'true';
        if (isset($token->recruiting_company_id)
        && (int) $token->recruiting_company_id == $token->recruiting_company_id) {
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
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
