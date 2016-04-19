<?php
use Sizzle\Database\{
    City,
    CityImages
};

$success = 'false';
$data = '';
if (logged_in() && is_admin()) {
    $City = new City($_POST['city_id'] ?? '');
    if ($City->id > 0) {
        // city exists! time to replace images...
        print_r($_FILES);

        $cities = $City->getCityImages();
        print_r($cities);
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
