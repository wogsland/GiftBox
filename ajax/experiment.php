<?php
use Sizzle\Bacon\Database\{
    RecruitingToken
};
//print_r($_SESSION);

$long_id =  $endpoint_parts[3] ?? null;
if (isset($_POST['id'], $long_id)) {
    switch ((int)$_POST['id']) {
        case 6:
            $success = false;
            $token = new RecruitingToken($long_id, 'long_id');
            if (isset($_SESSION['learnMore'],$_SESSION['learnMore'][$token->id])
                && 'Y' == $_SESSION['learnMore'][$token->id]
            ) {
                $success = true;
            }
            header('Content-Type: application/json');
            echo json_encode(array('learnMore' => $success));
            break;
        case 7:
            $success = false;
            $token = new RecruitingToken($long_id, 'long_id');
            if (isset($_SESSION['requestInterview'],$_SESSION['requestInterview'][$token->id])
                && 'Y' == $_SESSION['requestInterview'][$token->id]
            ) {
                $success = true;
            }
            header('Content-Type: application/json');
            echo json_encode(array('requestInterview' => $success));
            break;
        default:
            http_response_code(404);
    }
} else {
    http_response_code(404);
}
?>
