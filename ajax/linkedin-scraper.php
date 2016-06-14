<?php

$success = false;
$data = null;

if (isset($_POST['name']) && !empty($_POST['name'])) {
  $success = true;
  $name = $_POST['name'];
  $command = 'cd .. ; cd ajax/scraper ; sh run.sh ' . (string)$name;
  $data = shell_exec($command);
}

echo json_encode(array('success'=>$success, 'data'=>$data));
?>
