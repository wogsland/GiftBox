<?php
use \GiveToken\RecruitingToken;

$success = 'false';
$data = '';
if (logged_in() && is_admin()) {
    $long_id = escape_string($_POST['token_id']);
    $old_user_id = (int) $_POST['old_user_id'];
    $new_user_id = (int) $_POST['new_user_id'];
    if (!empty($long_id) && 0 != $old_user_id && 0 != $new_user_id) {
        $RecruitingToken = new RecruitingToken($long_id, 'long_id');
        if (isset($RecruitingToken->user_id) && $RecruitingToken->user_id == $old_user_id) {
            $RecruitingToken->user_id = $new_user_id;
            $RecruitingToken->save();
            $success = 'true';
        }
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
