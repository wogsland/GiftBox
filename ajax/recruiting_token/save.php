<?php
use \Sizzle\{
    City,
    HTML,
    RecruitingCompany,
    RecruitingToken,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    try {
        // Save the company (if new)
        if (!isset($_POST['recruiting_company_id']) || (int)$_POST['recruiting_company_id'] <= 0) {
            $RecruitingCompany = new RecruitingCompany();
            $RecruitingCompany->user_id = $user_id;
            $RecruitingCompany->name = escape_string($_POST['company'] ?? '');
            $RecruitingCompany->website = escape_string($_POST['company_website'] ?? '');
            $RecruitingCompany->values = escape_string($_POST['company_values'] ?? '');
            $RecruitingCompany->values = HTML::to($RecruitingCompany->values);
            $RecruitingCompany->facebook = escape_string($_POST['company_facebook'] ?? '');
            $RecruitingCompany->linkedin = escape_string($_POST['company_linkedin'] ?? '');
            $RecruitingCompany->youtube = escape_string($_POST['company_youtube'] ?? '');
            $RecruitingCompany->twitter = escape_string($_POST['company_twitter'] ?? '');
            $RecruitingCompany->google_plus = escape_string($_POST['company_google_plus'] ?? '');
            $RecruitingCompany->pinterest = escape_string($_POST['company_pinterest'] ?? '');
            $RecruitingCompany->save();
            $_POST['recruiting_company_id'] = $RecruitingCompany->id;
            unset($_POST['company']);
            unset($_POST['company_website']);
            unset($_POST['company_values']);
            unset($_POST['company_facebook']);
            unset($_POST['company_linkedin']);
            unset($_POST['company_youtube']);
            unset($_POST['company_twitter']);
            unset($_POST['company_google_plus']);
            unset($_POST['company_pinterest']);
        } else {
            $RecruitingCompany = new RecruitingCompany($_POST['recruiting_company_id']);
            if (isset($_POST['company'], $_POST['company_values'])) {
                $RecruitingCompany->name = escape_string($_POST['company'] ?? '');
                $RecruitingCompany->website = escape_string($_POST['company_website'] ?? '');
                $RecruitingCompany->values = escape_string($_POST['company_values'] ?? '');
                $RecruitingCompany->values = HTML::to($RecruitingCompany->values);
                $RecruitingCompany->facebook = escape_string($_POST['company_facebook'] ?? '');
                $RecruitingCompany->linkedin = escape_string($_POST['company_linkedin'] ?? '');
                $RecruitingCompany->youtube = escape_string($_POST['company_youtube'] ?? '');
                $RecruitingCompany->twitter = escape_string($_POST['company_twitter'] ?? '');
                $RecruitingCompany->google_plus = escape_string($_POST['company_google_plus'] ?? '');
                $RecruitingCompany->pinterest = escape_string($_POST['company_pinterest'] ?? '');
                $RecruitingCompany->save();
                unset($_POST['company']);
                unset($_POST['company_website']);
                unset($_POST['company_values']);
                unset($_POST['company_facebook']);
                unset($_POST['company_linkedin']);
                unset($_POST['company_youtube']);
                unset($_POST['company_twitter']);
                unset($_POST['company_google_plus']);
                unset($_POST['company_pinterest']);
            }
        }



        // Save the token
        $token = new RecruitingToken();
        $token->init((object)$_POST);
        $token->user_id = $user_id;

        // Polymer bug: convert the city name into an id
        if (isset($_POST['city_id'])) {
            $token->city_id = City::getIdFromName($token->city_id);
        }

        // Generate a long_id if this is a new token
        if (strlen($_POST['long_id']) == 0) {
            do {
                $token->long_id = substr(md5(microtime()), rand(0, 26), 20);
            } while (!$token->uniqueLongId());
        }

        // format long sections to HTML
        $token->job_description = HTML::to($token->job_description);
        $token->skills_required = HTML::to($token->skills_required);
        $token->responsibilities = HTML::to($token->responsibilities);
        $token->perks = HTML::to($token->perks);

        // save it
        $token->save();

        $response['status'] = "SUCCESS";
        $response['id'] = $token->id;
        $response['long_id'] = $token->long_id;
        $response['user_id'] = $token->user_id;
        $response['recruiting_company_id'] = $RecruitingCompany->id;
        $UserMilestone = new UserMilestone($user_id, 'Create Token');
    } catch (Exception $e) {
        error_log($e->getMessage());
        $response['status'] = "ERROR";
        $response['message'] = $e->getMessage();
        $repsonse['object'] = $e;
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
