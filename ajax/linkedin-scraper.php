<?php

$success = false;
$data = null;

function generate_key($length) {
  $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $string;
}

if (isset($_POST['link']) && !empty($_POST['link'])) {
  $success = true;
  $url = $_POST['link'];
  if (filter_var($url, FILTER_VALIDATE_URL)) {
    if (strpos($url, '/company/') !== false) {
      $key = generate_key(10);
      $fname = 'temp-' . $key . '.json';
      $fp = fopen($fname, 'w+');
      fwrite($fp, json_encode(array('url'=>$url)));
      fclose($fp);

      $target = 'data-' . $key . '.json';
      while (true) {
        if (file_exists($target)) {
          $data = (string)file_get_contents($target);
          //if ($temp != "null") $data = $temp;

          return;
        }
      }

    }
  }
}

$old_name = isset($_POST['oldName']) && !empty($_POST['oldName']);
$new_name = isset($_POST['newName']) && !empty($_POST['newName']);

if ($old_name && $new_name) {
  $success = true;
  $old_image = $_POST['oldName'];
  $new_image = $_POST['newName'];
  $param = (string)$old_image . ' ' . (string)$new_image;
  $command = 'cd .. ; cd ajax/scraper ; sh move.sh ' . $param;
  $data = shell_exec($command);
}

echo json_encode(array('success'=>$success, 'data'=>$data));

?>
