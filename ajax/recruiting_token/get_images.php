<?php
use \GiveToken\RecruitingTokenImage;

// collect id
$id = isset($endpoint_parts[4]) ? escape_string($endpoint_parts[4]) : '';

$success = 'false';
$data = '';
if ($id != '') {
    $RecruitingTokenImage = new RecruitingTokenImage();
    $images = $RecruitingTokenImage->getByRecruitingTokenLongId($id);
    if (!empty($images)) {
        $success = 'true';
        $data = $images;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
