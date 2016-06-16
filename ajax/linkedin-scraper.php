<?php

$success = false;
$data = null;

if (isset($_POST['name']) && !empty($_POST['name'])) {
  $success = true;
  $name = $_POST['name'];
  $command = 'cd .. ; cd ajax/scraper ; sh run.sh ' . (string)$name;
  $data = shell_exec($command);
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
