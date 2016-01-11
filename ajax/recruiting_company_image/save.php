<?php
use GiveToken\RecruitingCompanyImage;

date_default_timezone_set('America/Chicago');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['recruiting_company_id']) && isset($_POST['file_name'])) {
        $recruiting_company_id = (int) $_POST['recruiting_company_id'];
        $file_name = escape_string($_POST['file_name']);
        try {
            // Save the token image
            $recruiting_company_image = new RecruitingCompanyImage();
            $id = $recruiting_company_image->create($recruiting_company_id, $file_name);
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
        $response['message'] = "Recruiting token id unavailable.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
