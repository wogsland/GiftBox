<?php

$success = 'false';
$data = '';
if (isset($_POST['url']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
  $success = true;
  $url = $_POST['url'];
  $handle = curl_init($url);
  curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
  $response = curl_exec($handle);
  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
  $data = array('httpCode'=>$httpCode);
  curl_close($handle);
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
?>
