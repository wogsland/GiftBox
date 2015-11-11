<?php
use \GiveToken\RecruitingToken;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    try {
        // Save the token
        $token = new RecruitingToken();
        $token->init((object)$_POST, (object)$_FILES);
        $token->user_id = $user_id;
        do {
          $token->long_id = substr(md5(microtime()),rand(0,26),20);
        } while (!$token->uniqueLongId());
        $token->save();

        $response['status'] = "SUCCESS";
        $response['token_id'] = $token->long_id;
        $response['user_id'] = $token->user_id;
        $response['backdrop_picture'] = $token->backdrop_picture;
        $response['company_picture'] = $token->company_picture;

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
