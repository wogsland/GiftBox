<?php
require_once('./stripe/Stripe.php');
require_once('util.php');
include_once 'eventLogger.class.php';
require "User.class.php";

_session_start();

$response['status'] = "ERROR";
$response['message'] = "Unable to upgrade at this time.";

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$email = $_POST['email'];
$new_level = $_POST['newLevel'];

// Retrieve user by email
$user = User::fetch($email);

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = Stripe_Charge::create(array(
		"amount" => $amount,
		"currency" => "usd",
		"card" => $token,
		"description" => $email)
	);
	$response['status'] = "SUCCESS";
} catch(Exception $e) {
	$response['status'] = "ERROR";
	$response['message'] = "Stripe error: ". $e->getMessage();
}

if ($response['status'] == "SUCCESS") {
	$user->level = $new_level;
	$user->save();
	$event = new eventLogger($user->getId(), UPGRADE);
	$event->log();
	if (isset($_SESSION['level'])) {
		$_SESSION['level'] = $new_level;
	}
}

header('Content-Type: application/json');
echo json_encode($response);