function process_upgrade(token, payFrom) {
	var upgradeData = {
		newLevel: 2,
		amount: 299,
		stripeToken: token.id,
		email: token.email,
	};
	
	$.post("upgrade_ajax.php", upgradeData, function(data, textStatus, jqXHR){
		if(data.status === "SUCCESS") {
			if (payFrom == "SIGNUP") {
				switchToLogin();
			} else {
				location.reload();
			}
		} else if (data.status === "ERROR") {
			upgradeError("Upgrade failed: "+data.message);
		}  else {
			upgradeError("Upgrade failed", "Unknown data.status");
		}
	}).fail(function() {
		upgradeError("Upgrade failed!");
	});
}



function pay_with_stripe(email, payFrom) {
	
	var handler = StripeCheckout.configure({
		key: 'pk_test_6pRNASCoBOKtIshFeQd4XMUh',
		image: './images/logoicon.png',
		email: email,
		token: function(token) {
			process_upgrade(token, payFrom);
		}
	});

	// Open Checkout with further options
	handler.open({
		name: 'GiveToken Membership',
		description: "GiveToken Standard ($2.99)",
		amount: 299
	});
}
