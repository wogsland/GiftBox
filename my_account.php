<?php
use \GiveToken\User;

	include_once 'util.php';

	_session_start();

	$message = null;
	$first_name = null;
	$last_name = null;
	$email = null;
	$user_id = null;

	if (!logged_in()) {
		header('Location: '.$app_root);
	} else {
		$user = new User($_SESSION["user_id"]);
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
	<!-- TO DEVELOPER READING WEIRD CSS USING PURE AND BOOTSTRAP.... -->
	<!-- Recently switched from Pure to Bootstrap have not finished styling, its the account page; and we have a different one in the works so -->
	<!-- so were gonna ditch this not gonna try restyling, -->
	<!-- CHECK OUT new page at /profile.php can't be logged in though -->
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/util.js"></script>
	<script src="js/account.js"></script>
	<script src="pay_with_stripe.php"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="assets/gt-favicons.ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/gt-favicons.ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/gt-favicons.ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/gt-favicons.ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/gt-favicons.ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/gt-favicons.ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/gt-favicons.ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/gt-favicons.ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/gt-favicons.ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="assets/gt-favicons.ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/gt-favicons.ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/gt-favicons.ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/gt-favicons.ico/favicon-16x16.png">
	<link rel="manifest" href="assets/gt-favicons.ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- endFavicon -->

		<!-- =========================
		     STYLESHEETS
		============================== -->
		<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="css/bootstrap.min.css">

		<!-- FONT ICONS -->
		<link rel="stylesheet" href="assets/elegant-icons/style.css">
		<link rel="stylesheet" href="assets/app-icons/styles.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

		<!-- WEB FONTS -->
		<link href='//fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic' rel='stylesheet' type='text/css'>

		<!-- CAROUSEL AND LIGHTBOX -->
		<link rel="stylesheet" href="css/owl.theme.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/nivo-lightbox.css">
		<link rel="stylesheet" href="css/nivo_themes/default/default.css">

		<!-- ANIMATIONS -->
		<link rel="stylesheet" href="css/animate.min.css">

		<!-- CUSTOM STYLESHEETS -->
		<link rel="stylesheet" href="css/styles.css">

		<!-- COLORS -->
		<link rel="stylesheet" href="css/colors.css">

		<!-- RESPONSIVE FIXES -->
		<link rel="stylesheet" href="css/responsive.css">

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
			<!-- =========================
			     HEADER
			============================== -->
			<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

			<!-- SOLID COLOR BG -->
			<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->

				<!-- STICKY NAVIGATION -->
				<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
					<div class="container">
						<div class="navbar-header">

							<!-- LOGO ON STICKY NAV BAR -->
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#kane-navigation">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>

							<a class="navbar-brand" href="index.php"><img src="assets/img/logo-light.png" alt=""></a>

						</div>

						<!-- NAVIGATION LINKS -->
						<div class="navbar-collapse collapse" id="kane-navigation">
							<ul class="nav navbar-nav navbar-right main-navigation">
								<li><a href="index.php" class="external">Home</a></li>
								<li><a href="create.php" class="external">Create</a></li>
							</ul>
						</div>
					</div> <!-- /END CONTAINER -->
				</div> <!-- /END STICKY NAVIGATION -->

			</div>
			<!-- /END COLOR OVERLAY -->
			</header>
		</div>

		<div class = "container" id="my-account-form-wrapper">
			<p id="my-account-message"></p>
			<form class="jumbotron" id="account-form" name="account-form">
				<input type="hidden" name="user-id" id="user-id" value="<?php echo $user->getId() ?>">
				<legend>My Account</legend>
				<fieldset>
					<div class="form-group" >
						<div id="level-container">
							<label for="level-name">Level</label>
							<input class="form-control" name="level-name" id="level-name" type="text" placeholder="Level Name" value="<?php echo $user->level == 1 ? 'Basic':'Standard' ?>" disabled>
							<?php
							if (isset($_SESSION["level"]) && $_SESSION["level"] < 2) {
								echo '<button id="upgrade-button" type="button" class="btn success" onclick="payWithStripe(\''.$user->email_address.'\', \'MY_ACCOUNT\')">Upgrade</button>';
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="first-name">First Name</label>
						<input class="form-control" name="first-name" id="first-name" type="text" placeholder="First Name" value="<?php echo $user->first_name ?>" required>
					</div>

					<div class="form-group">
						<label for="last-name">Last Name</label>
						<input class="form-control" name="last-name" id="last-name" type="text" placeholder="Last Name" value="<?php echo $user->last_name ?>" required>
					</div>

					<div class="form-group">
						<label for="email">Email Address</label>
						<input class="form-control" name="email" id="email" type="email" placeholder="Email Address" value="<?php echo $user->email_address ?>" required>
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

</body>
</html>
