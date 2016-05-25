<?php
use \Sizzle\Bacon\Database\RecruitingTokenImage;

if (logged_in() && is_admin()) {
    $vars = ['fileName', 'tokenId'];
    foreach ($vars as $var) {
        $$var = $_POST[$var] ?? '';
    }
    $tokenId = (int) $tokenId;

    $success = 'false';
    $data = '';
    if ($fileName != '' && $tokenId > 0) {
        // remove existing screenshot(s)
        (new RecruitingToken($tokenId))->removeImages();

        // add new screenshot
        $id = (new RecruitingTokenImage())->create($fileName, $tokenId);
        $data = array('id'=>$id);
        $success = 'true';
    }
    header('Content-Type: application/json');
    echo json_encode(array('success'=>$success, 'data'=>$data));
}
