<?php
use \Sizzle\Bacon\Database\{
    User
};

date_default_timezone_set('America/Chicago');

$response['status'] = "ERROR";
$response['message'] = "Unable to upgrade at this time.";

// See your keys here https://dashboard.stripe.com/account
require_once __DIR__.'/../vendor/stripe/stripe-php/init.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'] ?? '';
$email = $_POST['email'] ?? '';
$plan = $_POST['plan'] ?? '';

// Retrieve the S!zzle user record
$user = (new User())->fetch($email);

try {
    // Create the customer with a plan, this will also charge the customer
    $customer = \Stripe\Customer::create(
        array(
        "source" => $token,
        "plan" => $plan,
        "email" => $email)
    );

    $response['status'] = "SUCCESS";
    $response['message'] = 'Successful upgrade';
} catch(Exception $e) {
    $response['status'] = "ERROR";
    $response['message'] = "Stripe error: ". $e->getMessage();
}

if ($response['status'] == "SUCCESS") {
    $active_until = new DateTime("now");
    $active_until->add(new DateInterval("P1M"));

    // Update the user properties
    $user->stripe_id = $customer->id;
    $user->active_until = $active_until->format("Y-m-d");

    // Save the user
    $user->save();

    // Set the session variables
    if (logged_in()) {
        $_SESSION['stripe_id'] = $customer->id;
    }
}
header('Content-Type: application/json');
echo json_encode($response);
