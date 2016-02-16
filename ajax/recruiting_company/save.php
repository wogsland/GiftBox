<?php
use Sizzle\{
    RecruitingCompany,
    HTML
};

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['recruiting_company_id'])) {
        $recruiting_company_id = (int) $_POST['recruiting_company_id'];
        try {
            $RecruitingCompany = new RecruitingCompany($recruiting_company_id);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $response['status'] = "ERROR";
            $response['message'] = $e->getMessage();
            $response['object'] = $e;
        }
        if ($RecruitingCompany->user_id != $user_id && !is_admin()) {
            $response['status'] = "ERROR";
            $response['message'] = 'User does not have permission to modify this company.';
        }
    } else {
        $RecruitingCompany = new RecruitingCompany();
    }
    if (!isset($response, $response['status']) || $response['status'] != "ERROR") {
        try {
            $RecruitingCompany->user_id = $user_id;
            $RecruitingCompany->name = escape_string($_POST['company'] ?? '');
            $RecruitingCompany->description = escape_string($_POST['company_description'] ?? '');
            $RecruitingCompany->website = escape_string($_POST['company_website'] ?? '');
            $RecruitingCompany->values = HTML::to($_POST['company_values'] ?? '');
            $RecruitingCompany->values = escape_string($RecruitingCompany->values);
            $RecruitingCompany->facebook = escape_string($_POST['company_facebook'] ?? '');
            $RecruitingCompany->linkedin = escape_string($_POST['company_linkedin'] ?? '');
            $RecruitingCompany->youtube = escape_string($_POST['company_youtube'] ?? '');
            $RecruitingCompany->twitter = escape_string($_POST['company_twitter'] ?? '');
            $RecruitingCompany->google_plus = escape_string($_POST['company_google_plus'] ?? '');
            $RecruitingCompany->pinterest = escape_string($_POST['company_pinterest'] ?? '');
            $RecruitingCompany->save();
            $response['status'] = "SUCCESS";
            $response['id'] = $RecruitingCompany->id;
            $response['user_id'] = $user_id;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $response['status'] = "ERROR";
            $response['message'] = $e->getMessage();
            $repsonse['object'] = $e;
        }
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
