<?php
$response['login_type'] = $_SESSION['login_type'] ?? null;
$response['app_root'] = '/';

session_unset();
session_destroy();

$response['status'] = "SUCCESS";

header('Content-Type: application/json');
echo json_encode($response);
