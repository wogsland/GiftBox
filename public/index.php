<?php
if (strpos($_SERVER['SERVER_NAME'], 'gosizzle.io')) {
  echo 'This page is under construction.';die;
}

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config.php';

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

/**
 * Route to the appropriate endpoint
   PLEASE ADD A TEST TO src/RoutingTest.php FOR EACH ENDPOINT ADDED HERE
 */
if (!isset($endpoint_parts[1])) {
    include __DIR__.'/../index.php';
} else {
    switch ($endpoint_parts[1]) {
        case '':
        case 'index.html':
        include __DIR__.'/../lp/old.php';
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
                case 'stalled_new_customers':
                include __DIR__.'/../admin/stalled_new_customers.php';
                break;
                case 'tokens':
                include __DIR__.'/../admin/token_stats.php';
                break;
                case 'top_ten':
                include __DIR__.'/../admin/top_ten.php';
                break;
                case 'transfer_token':
                include __DIR__.'/../admin/transfer_token.php';
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
        case 'create_recruiting':
        include __DIR__.'/../create_recruiting.php';
        break;
        case 'free_trial':
        include __DIR__.'/../lp/free-trial.php';
        break;
        case 'forgot_password':
        include __DIR__.'/../forgot_password.php';
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
                case 'JSXTransformer.js': // yuicompressor also barfs on this one
                include __DIR__.'/../js/JSXTransformer.js';
                break;
                default:
                include __DIR__.'/../error.php';
            }
        }
        break;
        case 'password_reset':
        include __DIR__.'/../password_reset.php';
        break;
        case 'payments':
        include __DIR__.'/../payments.php';
        break;
        case 'pricing':
        include __DIR__.'/../pricing.php';
        break;
        case 'privacy':
        include __DIR__.'/../privacypolicy.php';
        break;
        case 'profile':
        include __DIR__.'/../profile.php';
        break;
        case 'recruiting_made_easy':
        include __DIR__.'/../lp/bc1.php';
        break;
        case 'terms':
        include __DIR__.'/../termsservice.php';
        break;
        case 'thankyou':
        include __DIR__.'/../thankyou.php';
        break;
        case 'token':
        if ('recruiting' == $endpoint_parts[2] && isset($endpoint_parts[3])) {
            // don't display in native android browser
            $detect = new Mobile_Detect;
            if ($detect->isMobile()) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit') !== false
                && strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') === false
                && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === false) {
                    include __DIR__.'/../get_chrome.html';
                    die;
                }
            }
            include __DIR__.'/../recruiting_token.build.html';
        } else {
            include __DIR__.'/../error.php';
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
        case 'user':
        include __DIR__.'/../admin/user_info.php';
        break;
        case 'test':
        // this endpoint is just for non-production testing
        if (DEVELOPMENT) {
          include __DIR__.'/../lp/sizzle1.php';
          break;
        }
        default:
        include __DIR__.'/../error.php';
    }
}
