<?php
require __DIR__.'/../vendor/autoload.php';
//print_r($_SERVER);
//echo $_SERVER['REQUEST_URI'];

// Parse URI
$pieces = explode('?', $_SERVER['REQUEST_URI']);
$endpoint = $pieces[0];
$endpoint_parts = explode('/', $endpoint);
if (isset($pieces[1])) {
    $gets = $pieces[1];
    $gets = explode('&', $gets);
    $get_parts = array();
    foreach ($gets as $get) {
        $parts = explode('=', $get);
        $get_parts[$parts[0]] = $parts[1];
    }
}


if ('token' == $endpoint_parts[1] && 'recruiting' == $endpoint_parts[2]) {
    // don't display in native android browser
    $detect = new Mobile_Detect;
    if ($detect->isMobile()) {
        //echo '<pre>';print_r($detect);die;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit') !== false
        && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === false) {
            include __DIR__.'/../get_chrome.html';
            die;
        }
    }
    include __DIR__.'/../recruiting_token.build.html';
    die;
}

switch ($endpoint_parts[1]) {
    case 'about':
    include __DIR__.'/../about.php';
    case 'ajax':
    include __DIR__.'/../ajax/route.php';
    default:
    include __DIR__.'/../error.php';
}
?>
