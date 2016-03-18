<?php
use Sizzle\Database\RecruitingCompanyVideo;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        try {
            // Delete the token video
            $recruiting_company_video = new RecruitingCompanyVideo($id);
            $deleted = $recruiting_company_video->delete();
            if ($deleted) {
                $response['status'] = "SUCCESS";
            } else {
                $response['status'] = "ERROR";
                $response['message'] = "Recruiting token video delete() failed.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $response['status'] = "ERROR";
            $response['message'] = $e->getMessage();
            $repsonse['object'] = $e;
        }
    } else {
        $response['status'] = "ERROR";
        $response['message'] = "Recruiting token video id unavailable.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "Session information unavailable.";
}
header('Content-Type: application/json');
echo json_encode($response);
