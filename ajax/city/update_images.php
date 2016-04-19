<?php
use Aws\S3\S3Client;
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

        $s3Client = S3Client::factory(array(
            'profile' => 'sizzle',
            'region'  => 'us-west-2',
            'version' => '2006-03-01'
        ));
        //print_r($s3Client);
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
