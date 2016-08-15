<?php
use \Sizzle\Bacon\Database\LandingPage;

// If the user hasn't been here, randomize the experience
// Otherwise, take them to the page they saw before
if (!isset($_SESSION['landing_page'], $_SESSION['landing_page']['learn_more'], $_SESSION['landing_page']['learn_more']['script'], $_SESSION['landing_page']['learn_more']['id'])) {
    $LandingPage = new LandingPage(rand(9,10));
    $_SESSION['landing_page']['learn_more']['script'] = $LandingPage->script;
    $_SESSION['landing_page']['learn_more']['id'] = $LandingPage->id;
} else {
    $LandingPage = new LandingPage($_SESSION['landing_page']['learn_more']['id']);
}
$LandingPage->recordHit($_COOKIE['visitor'] ?? '');
require __DIR__.'/'.$_SESSION['landing_page']['learn_more']['script'];
