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

if (isset($_POST['clear']) && !empty($_POST['clear'])) {
  $key = $_POST['clear'];
  $success = true;
  if ($key == 'refresh') {
    $files = scandir('uploads/');

    for ($i = 0; $i < sizeof($files); $i++) {
      if (preg_match('/[A-Za-z]+/', $files[$i])
          && strpos($files[$i], '.png') !== false) {
        $f = 'uploads/' . (string)$files[$i];
        unlink($f);
      }
    }
  } else {
    if (file_exists('uploads/heroImage-' . $key . '.png')) {
      unlink('uploads/heroImage-' . $key . '.png');
    }
    if (file_exists('uploads/legacyLogo-' . $key . '.png')) {
      unlink('uploads/legacyLogo-' . $key . '.png');
    }
  }
}

if (isset($_POST['link']) && !empty($_POST['link'])) {
  $url = $_POST['link'];
  if (filter_var($url, FILTER_VALIDATE_URL)) {
    if (strpos($url, '/company/') !== false) {
      // generate key for collision protection
      $key = generate_key(10);

      // write url to temp JSON file
      $fname = 'temp-' . $key . '.json';
      $fp = fopen('uploads/' . $fname, 'w+');
      fwrite($fp, json_encode(array('url'=>$url)));
      fclose($fp);

      // synchronously call script and wait for response
      // note: shell_exec doesn't take in POST variables
      $command = 'cd .. ; cd ajax/scraper ; sh run.sh ' . $fname;
      $data = shell_exec($command);
      $success = true;
    }
  }
}

$old_name = isset($_POST['oldName']) && !empty($_POST['oldName']);
$new_name = isset($_POST['newName']) && !empty($_POST['newName']);

if ($old_name && $new_name) {
  $old_image = $_POST['oldName'];
  $new_image = $_POST['newName'];

  // rename the images for database
  if (file_exists('uploads/' . $old_image)) {
    rename('uploads/' . $old_image, 'uploads/' . $new_image);
  }

  $success = true;
}

echo json_encode(array('success'=>$success, 'data'=>$data));

?>
