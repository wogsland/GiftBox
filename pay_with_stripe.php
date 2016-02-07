<?php
    header('Content-Type: text/javascript');
?>

function upgradeError(message) {
	console.log(message);
}

function processUpgrade(token, payFrom) {
	var upgradeData = {
		newLevel: 2,
		plan: 'recruiting',
		stripeToken: token.id,
		email: token.email,
	};

	var eventTarget = event.target;
	$(eventTarget).addClass("disable-clicks");
	$.post("/ajax/upgrade", upgradeData, function(data, textStatus, jqXHR){
		if(data.status === "SUCCESS") {
			if (payFrom === "SIGNUP") {
				signupClose();
				openMessage("Welcome!", "You have successfully signed up with S!zzle.  An activation email has been sent to "+upgradeData.email+".  Please activate your account before logging in.");
			} else if (payFrom === "UPGRADE") {
        window.location.href = '/profile';
      } else {
				location.reload();
			}
		} else if (data.status === "ERROR") {
			upgradeError("Upgrade failed: "+data.message);
		}  else {
			upgradeError("Upgrade failed: unknown data.status");
		}
	}).fail(function() {
		upgradeError("Upgrade failed!");
	}).always(function() {
		$(eventTarget).addClass("disable-clicks");
	});

function payWithStripe(email, payFrom) {

	var handler = StripeCheckout.configure({
		key: '<?php echo STRIPE_PUBLISHABLE_KEY; ?>',
//		image: '../images/logoicon.png',
		email: email,
		token: function(token) {
			processUpgrade(token, payFrom);
		}
	});

	// Open Checkout with further options
	handler.open({
		name: 'GiveToken',
		description: "GiveToken ($250/month)",
		amount: 25000
	});
}
