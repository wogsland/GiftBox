<?php
use \Sizzle\Database\RecruitingCompanyVideo;

// collect id
$id = escape_string($endpoint_parts[4] ?? '');

$success = 'false';
$data = '';
if ($id != '') {
    $RecruitingCompanyVideo = new RecruitingCompanyVideo();
    $videos = $RecruitingCompanyVideo->getByRecruitingTokenLongId($id);
    if (!empty($videos)) {
        $success = 'true';
        $data = $videos;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
