<?php
require_once __DIR__.'/../config.php';
_session_start();

// Parse URI
$pieces = explode('?', $_SERVER['REQUEST_URI']);
$endpoint = $pieces[0];
$endpoint_parts = explode('/', $endpoint);
$gets = $pieces[1];
$gets = explode('&', $gets);
$get_parts = array();
foreach ($gets as $get) {
    $parts = explode('=', $get);
    $get_parts[$parts[0]] = $parts[1];
}

// Execute script if exists
$file1 = $endpoint_parts[2] . '.php';
$file2 = $endpoint_parts[2] . '/' . $endpoint_parts[3] . '.php';
if (file_exists($file1)) {
    include $file1;
} elseif (file_exists($file2)) {
    include $file2;
}
