<?php
include_once 'config.php';

_session_start();
$_SESSION['app_root'] = $app_root;
header('Content-Type: application/json');
echo json_encode($_SESSION);
