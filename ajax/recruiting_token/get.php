<?php
use \Sizzle\Bacon\Database\{
    RecruitingCompany,
    RecruitingToken,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

// collect id
$id = $endpoint_parts[4] ?? '';

$success = 'false';
$data = '';
if ($id != '') {
    $token = new RecruitingToken($id, 'long_id');
    if (isset($token->id)) {
        $success = 'true';
        $data = $token->toArray();
        if (isset($token->recruiting_company_id)
            && (int) $token->recruiting_company_id > 0
        ) {
            $company = new RecruitingCompany($token->recruiting_company_id);
            if (isset($company->id)) {
                $data['company'] = $company->name;
                $data['company_logo'] = $company->logo;
                $data['company_description'] = $company->description;
                $data['company_website'] = $company->website;
                $data['company_values'] = $company->values;
                $data['company_facebook'] = $company->facebook;
                $data['company_linkedin'] = $company->linkedin;
                $data['company_youtube'] = $company->youtube;
                $data['company_twitter'] = $company->twitter;
                $data['company_google_plus'] = $company->google_plus;
                $data['company_pinterest'] = $company->pinterest;
            }
        }
        $cities = $token->getCities();
        if (count($cities) > 0) {
            $data['city_id'] = ($cities[0])->id;
        }
        $data = (object) $data;

        if (!logged_in()) {
            $UserMilestone = new UserMilestone($token->user_id, 'Token View By Non-User');
        }
    }
}
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data);
echo json_encode($result);
