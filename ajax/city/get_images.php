<?php
use Sizzle\CityImage;

$success = 'false';
$data = '';
if (logged_in()) {
  $vars = [
    'city_id'
  ];
  $city_id = $_POST['city_id'];
  if (isset($city_id) && '' != $city_id) {
    $HOST_NAME = "http://city.images.s3-us-west-2.amazonaws.com";
    $imageUrls = CityImage::getAllImageUrlsForCity(escape_string($city_id));
    $data = array();
    foreach ($imageUrls as $url) {
      $fullUrl = $HOST_NAME.$url->image_file;
      $data[count($data)] = $fullUrl;
    }
    $success = 'true';
  }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
