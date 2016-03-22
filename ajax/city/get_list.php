<?php
use Sizzle\Database\City;

// collect piece
$part = escape_string($_POST['typed'] ?? '');

$success = 'false';
$data = '';
if ('' != $part) {
    $cities = (new City())->match10($part);
    if (count($cities) > 0) {
        $success = 'true';
        $data = $cities;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
