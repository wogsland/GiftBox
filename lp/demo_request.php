<?php
use \Sizzle\Bacon\Database\LandingPage;

// If the user hasn't been here, randomize the experience
// Otherwise, take them to the page they saw before
if (!isset($_SESSION['landing_page'], $_SESSION['landing_page']['script'], $_SESSION['landing_page']['id'])) {
    $LandingPage = new LandingPage(rand(7,8));
    print_r($LandingPage);die;
    $_SESSION['landing_page']['script'] = $LandingPage->script;
    $_SESSION['landing_page']['id'] = $LandingPage->id;
} else {
    $LandingPage = new LandingPage($_SESSION['landing_page']['id']);
}
$LandingPage->recordHit($_COOKIE['visitor'] ?? '');
require __DIR__.'/'.$_SESSION['landing_page']['script'];
