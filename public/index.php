<?php
use Sizzle\Route;

try{
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../config.php';

    $apis = [
        'api.gosizzle.local',
        'api.gosizzle.io'
    ];
    if (in_array($_SERVER['SERVER_NAME'], $apis)) {
        include __DIR__.'/../api/route.php';
    } else {
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
                $get_parts[$parts[0]] = $parts[1] ?? null;
            }
        }

        $route = new Route($endpoint_parts, $get_parts);
        $route->go();
    }
} catch (Throwable $thrown) {
    http_response_code(500);
    require_once __DIR__.'/500.html';
}
