<?php
use Sizzle\City;

// collect id
$id = (int) ($endpoint_parts[4] ?? 0);

$success = 'false';
$data = '';
if ($id > 0) {
    $City = new City($id);
    if (isset($City->id)) {
        $success = 'true';
        $data = $City;
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
