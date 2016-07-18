<?php
use \Sizzle\Bacon\Database\LandingPage;

// If the user hasn't been here, randomize the experience
// Otherwise, take them to the page they saw before
if (!isset($_SESSION['landing_page']['demo_request'], $_SESSION['landing_page']['demo_request']['script'], $_SESSION['landing_page']['demo_request']['id'])) {
    $LandingPage = new LandingPage(rand(7,8));
    $_SESSION['landing_page']['demo_request']['script'] = $LandingPage->script;
    $_SESSION['landing_page']['demo_request']['id'] = $LandingPage->id;
} else {
    $LandingPage = new LandingPage($_SESSION['landing_page']['demo_request']['id']);
}
$LandingPage->recordHit($_COOKIE['visitor'] ?? '');
require __DIR__.'/'.$_SESSION['landing_page']['demo_request']['script'];
