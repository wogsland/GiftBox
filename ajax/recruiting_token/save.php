<?php
use \GiveToken\RecruitingToken;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    try {
        // Save the token
        $token = new RecruitingToken();
        $token->init((object)$_POST, (object)$_FILES);
        $token->user_id = $user_id;
        $token->save();

        $response['status'] = "SUCCESS";
        $response['token_id'] = $token->id;
        $response['user_id'] = $token->user_id;
        $response['backdrop_picture'] = $token->backdrop_picture;
        $response['company_picture'] = $token->company_picture;

    } catch (Exception $e) {
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
