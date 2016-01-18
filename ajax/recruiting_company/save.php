<?php
use Sizzle\RecruitingCompany;

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
            $repsonse['object'] = $e;
        }
    } else {
        $RecruitingCompany = new RecruitingCompany();
    }
    try {
        $RecruitingCompany->save();
        $response['status'] = "SUCCESS";
        $response['id'] = $recruiting_company_image->id;
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
