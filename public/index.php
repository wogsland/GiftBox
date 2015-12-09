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

// route to the appropriate endpoint
if (!isset($endpoint_parts[1])) {
    include __DIR__.'/../index.php';
} else {
    switch ($endpoint_parts[1]) {
        case '':
        case 'index.html':
        include __DIR__.'/../index.php';
        break;
        case 'about':
        include __DIR__.'/../about.php';
        break;
        case 'activate':
        include __DIR__.'/../activate.php';
        break;
        case 'admin':
        if (!isset($endpoint_parts[2]) || '' == $endpoint_parts[2]) {
            include __DIR__.'/../admin.php';
        } else {
            switch ($endpoint_parts[2]) {
                case 'active_users':
                include __DIR__.'/../admin/active_users.php';
                break;
                case 'add_city':
                include __DIR__.'/../admin/add_city.php';
                break;
                case 'top_ten':
                include __DIR__.'/../admin/top_ten.php';
                break;
                case 'visitors':
                include __DIR__.'/../admin/visitors.php';
                break;
                default:
                include __DIR__.'/../error.php';
            }
        }
        break;
        case 'ajax':
        include __DIR__.'/../ajax/route.php';
        break;
        case 'community':
        include __DIR__.'/../community.php';
        break;
        case 'create':
        include __DIR__.'/../create.php';
        break;
        case 'create_recruiting':
        include __DIR__.'/../create_recruiting.php';
        break;
        case 'invoice':
        include __DIR__.'/../invoice.php';
        break;
        case 'js':
        if (!isset($endpoint_parts[2]) || '' == $endpoint_parts[2]) {
            include __DIR__.'/../error.php';
        } else {
            switch ($endpoint_parts[2]) {
                case 'pay_with_stripe.js':
                include __DIR__.'/../pay_with_stripe.php';
                break;
                case 'create.js': // this file is too broken for yuicompressor
                include __DIR__.'/../js/create.js';
                break;
                case 'JSXTransformer.js': // yuicompressor also barfs on this one
                include __DIR__.'/../js/JSXTransformer.js';
                break;
                default:
                include __DIR__.'/../error.php';
            }
        }
        break;
        case 'payments':
        include __DIR__.'/../payments.php';
        break;
        case 'preview':
        case 'preview.php':
        include __DIR__.'/../preview.php';
        break;
        case 'profile':
        include __DIR__.'/../profile.php';
        break;
        case 'pricing':
        include __DIR__.'/../pricing.php';
        break;
        case 'privacy':
        include __DIR__.'/../privacypolicy.php';
        break;
        case 'terms':
        include __DIR__.'/../termsservice.php';
        break;
        case 'token':
        if ('recruiting' == $endpoint_parts[2]) {
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
        }
        break;
        case 'tokens':
        include __DIR__.'/../tokens.php';
        break;
        case 'token_responses':
        include __DIR__.'/../token_responses.php';
        break;
        case 'upgrade':
        include __DIR__.'/../upgrade.php';
        break;
        case 'upload':
        include __DIR__.'/../upload.php';
        break;
        default:
        include __DIR__.'/../error.php';
    }
}
