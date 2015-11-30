<?php
use \GiveToken\RecruitingTokenVideo;

// collect id
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';

$success = 'false';
$data = '';
if ($id != '') {
    $RecruitingTokenVideo = new RecruitingTokenVideo();
    $images = $RecruitingTokenVideo->getByRecruitingTokenLongId($id);
    if (!empty($images)) {
        $success = 'true';
        $data = $images;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
