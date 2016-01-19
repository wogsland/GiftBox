<?php
use Sizzle\Route;

if (strpos($_SERVER['SERVER_NAME'], 'gosizzle.io')) {
  echo 'This page is under construction.';die;
}

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config.php';

// Parse URI
$pieces = explode('?', $_SERVER['REQUEST_URI']);
$endpoint = $pieces[0];
$endpoint_parts = explode('/', $endpoint);
$get_parts = array();
if (isset($pieces[1])) {
    $gets = $pieces[1];
    $gets = explode('&', $gets);
    foreach ($gets as $get) {
        $parts = explode('=', $get);
        $get_parts[$parts[0]] = isset($parts[1]) ? $parts[1] : null;
    }
}

$route = new Route($endpoint_parts, $get_parts);
$route->go();
