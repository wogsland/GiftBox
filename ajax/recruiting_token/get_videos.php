<?php
use \Sizzle\Bacon\Database\RecruitingCompanyVideo;

// collect id
$id = $endpoint_parts[4] ?? '';

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
