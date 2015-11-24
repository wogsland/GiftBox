<?php
use GiveToken\RecruitingTokenVideo;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['recruiting_token_id'])) {
        $recruiting_token_id = $_POST['recruiting_token_id'];
        if (isset($_POST['video_url'])) {
            $video_url = $_POST['video_url'];
        }
        if (isset($_POST['thumbnail_src'])) {
            $thumbnail_src = $_POST['thumbnail_src'];
        }
        try {
            // Save the token video
            $recruiting_token_video = new RecruitingTokenVideo();
            $id = $recruiting_token_video->create($recruiting_token_id, $video_url, $thumbnail_src);
            $response['status'] = "SUCCESS";
            $response['id'] = $recruiting_token_video->id;
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
