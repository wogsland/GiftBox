<?php
use Sizzle\Database\RecruitingCompanyImage;

date_default_timezone_set('America/Chicago');

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['recruiting_company_id'], $_POST['file_name'])) {
        try {
            // Save the token image
            $id = (new RecruitingCompanyImage())->create($_POST['recruiting_company_id'], $_POST['file_name']);
            $response['status'] = "SUCCESS";
            $response['id'] = $id;

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
