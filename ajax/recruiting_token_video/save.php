<?php
use GiveToken\RecruitingToken;
use GiveToken\RecruitingTokenVideo;

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    if (isset($_POST['recruiting_token_id'])) {
        $recruiting_token_id = (int) $_POST['recruiting_token_id'];
        if (isset($_POST['source'], $_POST['source_id'])) {
            $source = escape_string($_POST['source']);
            $source_id = escape_string($_POST['source_id']);
            if (in_array($source, ['youtube','vimeo'])) {
                // see is token belongs to this user
                $recruiting_token = new RecruitingToken($recruiting_token_id, 'id');
                if ($recruiting_token->user_id == $user_id) {
                    try {
                        // Save the token video
                        $recruiting_token_video = new RecruitingTokenVideo();
                        $id = $recruiting_token_video->create($recruiting_token_id, $source, $source_id);
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
