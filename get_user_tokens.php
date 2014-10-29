<?php
include_once 'util.php';
session_start();

$sql = "SELECT id, name from giftbox where user_id = ".$_SESSION['user_id']." ORDER BY name";
$results = execute_query($sql);
$response = $results->fetch_all();

header('Content-Type: application/json');
echo json_encode($response);