<?php
use GiveToken\City;

// collect id
$id = isset($endpoint_parts[4]) ? (int) $endpoint_parts[4] : 0;

$success = 'false';
$data = '';
if ($id > 0) {
    $City = new City($id);
    if (isset($City->id)) {
        $success = 'true';
        $data = $City;
    }
}
echo json_encode(array('success'=>$success, 'data'=>$data));
