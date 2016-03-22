<?php
use Sizzle\Database\RecruitingCompany;
use Sizzle\Database\RecruitingCompanyVideo;
use Sizzle\Database\RecruitingToken;

date_default_timezone_set('America/Chicago');

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    if (isset($_POST['recruiting_company_id'])) {
        $recruiting_company_id = (int) $_POST['recruiting_company_id'];
        if (isset($_POST['source'], $_POST['source_id'])) {
            $source = escape_string($_POST['source']);
            $source_id = escape_string($_POST['source_id']);
            if (in_array($source, ['youtube','vimeo'])) {
                // see if company belongs to this user
                $RecruitingCompany = new RecruitingCompany($recruiting_company_id, 'id');
                if ($RecruitingCompany->user_id == $user_id || is_admin()) {
                    try {
                        // Save the token video
                        $recruiting_company_video = new RecruitingCompanyVideo();
                        $id = $recruiting_company_video->create($recruiting_company_id, $source, $source_id);
                        $response['status'] = "SUCCESS";
                        $response['id'] = $recruiting_company_video->id;
                    } catch (Exception $e) {
                        error_log($e->getMessage());
                        $response['status'] = "ERROR";
                        $response['message'] = $e->getMessage();
                        $repsonse['object'] = $e;
                    }
                } else {
                    $response['status'] = "ERROR";
                    $response['message'] = "User does not have access to this token.";
                }
            } else {
                $response['status'] = "ERROR";
                $response['message'] = "Must be a YouTube or Vimeo video.";
            }
        } else {
            $response['status'] = "ERROR";
            $response['message'] = "Source and source id required.";
        }
    } else {
        $response['status'] = "ERROR";
        $response['message'] = "Recruiting token id required.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "User must be logged in.";
}
header('Content-Type: application/json');
echo json_encode($response);
