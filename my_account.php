<?php
	include_once 'util.php';
	include_once 'config.php';
	include_once 'eventLogger.class.php';
	
	$message = null;
	$first_name = null;
	$last_name = null;
	$email = null;
	
	if (!logged_in()) {
		header('Location: '.$app_root);
	} else {
		if (isset($_POST['first-name'])) {
			execute("UPDATE user set first_name = '".$_POST['first-name']."', last_name = '".$_POST['last-name']."', email_address = '".$_POST['email']."' WHERE id = ".$_COOKIE['user_id']);

			$event = new eventLogger($_COOKIE['user_id'], UPDATE_ACCOUNT_INFO);
			$event->log();

			$first_name = $_POST['first-name'];
			$last_name = $_POST['last-name'];
			$email = $_POST['email'];
			
			$message = "Your changes have been saved.";
		} else {
			$results = execute_query("SELECT * FROM user WHERE id = ".$_COOKIE['user_id']);
			if ($results->num_rows == 1) {
				$user = $results->fetch_object();
				$first_name = $user->first_name;
				$last_name = $user->last_name;
				$email = $user->email_address;
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - My Account</title>
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
    <script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/account.js"></script>
		
	<script>
		$(document).ready(function() {
			$('.open-popup-link').magnificPopup({
				type: 'inline',
				midClick: true
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
			<p class="dialog-message" id="save-password-message"><?php echo $message ?></p>
			<form class="pure-form pure-form-aligned" id="account-form" name="account-form" method="post" action="my_account.php">
				<legend>My Account</legend>
				<fieldset>
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
					
					<input type="submit" id="save-my-account-button" class="pure-button pure-button-primary" value="Save Changes">
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

</body>
</html>
