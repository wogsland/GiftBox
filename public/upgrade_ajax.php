<?php
require_once('./stripe/Stripe.php');
require_once('util.php');
include_once 'eventLogger.class.php';

_session_start();

$response['status'] = "ERROR";
$response['message'] = "Unable to register at this time.";

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$email = $_POST['email'];
$amount = $_POST['amount'];
$new_level = $_POST['newLevel'];
$user_id = $_SESSION['user_id'];

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
	execute("UPDATE user set level = ".$new_level." WHERE id = ".$user_id);
	$event = new eventLogger($_SESSION['user_id'], UPGRADE);
	$event->log();
	$_SESSION['level'] = $new_level;

	$result = execute_query("SELECT name from level where id = ".$new_level);
	$level_name = $result->fetch_object();
	$response['level_name'] = $level_name->name;
}

header('Content-Type: application/json');
echo json_encode($response);