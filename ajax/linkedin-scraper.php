<?php

$success = false;
$data = null;

if (isset($_POST['link']) && !empty($_POST['link'])) {
  $success = true;
  $url = $_POST['link'];
  if (filter_var($url, FILTER_VALIDATE_URL)) {
    $fp = fopen('temp.json', 'w+');
    fwrite($fp, json_encode(array('url'=>$url)));
    fclose($fp);
  }
  //$command = 'cd .. ; cd ajax/scraper ; sh run.sh ' . (string)$name;
  //$data = shell_exec($command);
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
