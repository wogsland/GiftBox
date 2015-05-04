<?php
	include_once 'util.php';
	include_once 'config.php';
	
	_session_start();
	
	$message = null;
	$first_name = null;
	$last_name = null;
	$email = null;
	$user_id = null;
	
	if (!logged_in()) {
		header('Location: '.$app_root);
	} else {
		$results = execute_query("SELECT user.*, level.id, level.name FROM user, level WHERE user.level = level.id and user.id = ".$_SESSION['user_id']);
		if ($results->num_rows == 1) {
			$user = $results->fetch_object();
			$first_name = $user->first_name;
			$last_name = $user->last_name;
			$email = $user->email_address;
			$level = $user->name;
			$user_id = $user->id;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!-- SITE TITLE -->
	<title>GiveToken.com - My Account</title>
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/pure/pure-min.css">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/util.js"></script>
	<script src="js/account.js"></script>
		
	<script>
		$(document).ready(function() {
			$('.open-popup-link').magnificPopup({
				type: 'inline',
				midClick: true
			});
		});

	</script>
	
	<script>
		$(function() {
			$( "#upgrade-dialog" ).dialog({
				autoOpen: false,
				resizable: false,
				height:500,
				width: 350,
				modal: true,
				open: function( event, ui ) {
					$("#upgrade-status").text("");
					$("#upgrade-status").removeClass("red-text");
				}
			});
		});
	</script>	
	
	
</head>
<body>
	<div id="content-wrapper">
		<div class="header-wrapper" id="create-header-wrapper">
			<header>
				<h1>
					<a id="create-home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
				</h1>
				<nav id="create-top-nav">
					<ul>
						<li>
							<a href="<?php echo $app_root ?>">Home</a>
						</li>
					</ul>
				</nav>
			</header>
		</div>
		
		<div id="my-account-form-wrapper">
			<p id="my-account-message"></p>
			<form class="pure-form pure-form-aligned" id="account-form" name="account-form" method="post" action="my_account.php">
				<input type="hidden" name="user-id" id="user-id" value="<?php echo $user_id ?>">
				<legend>My Account</legend>
				<fieldset>
					<div class="pure-control-group">
						<label for="level-name">Level</label>
						<input name="level-name" id="level-name" type="text" placeholder="Level Name" value="<?php echo $level ?>" disabled>
						<a class="pure-button green-button" id="upgrade-button" href="javascript:void(0)" onclick="$('#upgrade-dialog').dialog('open');">Upgrade</a>
					</div>

					<div class="pure-control-group">
						<label for="first-name">First Name</label>
						<input name="first-name" id="first-name" type="text" placeholder="First Name" value="<?php echo $first_name ?>" required>
					</div>

					<div class="pure-control-group">
						<label for="last-name">Last Name</label>
						<input name="last-name" id="last-name" type="text" placeholder="Last Name" value="<?php echo $last_name ?>" required>
					</div>

					<div class="pure-control-group">
						<label for="email">Email Address</label>
						<input name="email" id="email" class="pure-input-1-2" type="email" placeholder="Email Address" value="<?php echo $email ?>" required>
					</div>

					<div class="pure-control-group">
						<label for="button"></label>
						<a class="pure-button open-popup-link" href="#change-password-form">Change Password</a>
					</div>
					
					<input type="button" id="save-my-account-button" class="pure-button pure-button-primary" value="Save Changes" onclick="saveMyAccount()">
				</fieldset>
			</form>
		</div>

	</div>

	<form id="change-password-form" class="white-popup mfp-hide" name="change-password-form">
		<h1 class="dialog-header">Change Password</h1>
		<div id="dialog-form-container">
			<p class="dialog-message" id="change-password-message"></p>
			<input class="dialog-input" id="new-password" name="new-password" type="password" placeholder="New Password" size="30">
			<input class="dialog-input" id="confirm-password" name="confirm-password" type="password" placeholder="Confirm Password" size="30">
			<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="changePassword()">Change Password</a>
		</div>
	</form>

	<div id="upgrade-dialog" title="Upgrade">
		<p id="upgrade-status"></p>
		<form class="pure-form" id="upgrade-form">
			<legend style="margin-top: 20px;">Choose an upgrade option:</legend>
			<?php
				$results = execute_query("SELECT id, name, price from level order by id");
				$last = null;
				while ($level = $results->fetch_object()) {
					if ($level->id > $_SESSION['level']) {
						echo '<label for="'.$level->name.'" class="pure-radio">'.PHP_EOL;
						echo '<input class="level-value" id="'.$level->name.'" type="radio" name="level-value" value="'.$level->id.'" price="'.$level->price.'">'.PHP_EOL;
						echo $level->name." ($".$level->price.")".PHP_EOL;
						echo "</label>";
						$last = $level->name;
						$last_value = $level->id;
					}
				}
				if ($last) {
					echo '<script>$("#'.$last.'").attr("checked", "checked");</script>';
				} else {
					echo '<script> $("#upgrade-button").remove();</script>';
				}
			?>

			<script src="https://checkout.stripe.com/checkout.js"></script>

			<button class="pure-button" id="pay-button">Pay</button>

			<script>
				var handler = StripeCheckout.configure({
					key: 'pk_test_6pRNASCoBOKtIshFeQd4XMUh',
					image: './images/logoicon.png',
					token: function(token) {
						process_upgrade(token);
					}
				});

				document.getElementById('pay-button').addEventListener('click', function(e) {
					// Open Checkout with further options
					var upgradeAmount = $('input[name=level-value]:checked', '#upgrade-form').attr('price');
					var upgradeDescription = $('input[name=level-value]:checked', '#upgrade-form').attr('id');
					handler.open({
						name: 'GiveToken Upgrade',
						description: upgradeDescription+" ($"+upgradeAmount+")",
						amount: upgradeAmount * 100
					});
					e.preventDefault();
				});
			</script>		
		</form>
	</div>
	

</body>
</html>