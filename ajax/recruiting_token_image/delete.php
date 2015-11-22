<?php
use GiveToken\RecruitingTokenImage;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        try {
            // Delete the token image
            $recruiting_token_image = new RecruitingTokenImage($id);
            $deleted = $recruiting_token_image->delete();
            if ($deleted) {
                $response['status'] = "SUCCESS";
            } else {
                $response['status'] = "ERROR";
                $response['message'] = "Recruiting token image delete() failed.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $response['status'] = "ERROR";
            $response['message'] = $e->getMessage();
            $repsonse['object'] = $e;
        }
    } else {
        $response['status'] = "ERROR";
        $response['message'] = "Recruiting token image id unavailable.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
