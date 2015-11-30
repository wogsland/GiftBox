<?php
use GiveToken\RecruitingTokenImage;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['recruiting_token_id']) && isset($_POST['file_name'])) {
        $recruiting_token_id = $_POST['recruiting_token_id'];
        $file_name = $_POST['file_name'];
        try {
            // Save the token image
            $recruiting_token_image = new RecruitingTokenImage();
            $id = $recruiting_token_image->create($recruiting_token_id, $file_name);
            $response['status'] = "SUCCESS";
            $response['id'] = $recruiting_token_image->id;

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
