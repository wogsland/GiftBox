<?php
use \GiveToken\User;
use \Stripe\Charge;
use \Stripe\Stripe;

$success = 'false';
$data = '';
if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['stripe_id'])) {
        // get stripe_id
        $user = new User($_SESSION['user_id']);
        $_SESSION['stripe_id'] = $user->stripe_id;
    }
    Stripe::setApiKey($stripe_secret_key);
    $success = 'true';
    $data = Charge::all(array('customer'=>$_SESSION['stripe_id']));
    $data = Charge::all(array('customer'=>'ch_17FRCyBaKvkB7XXNUkYsEOuI'));
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
