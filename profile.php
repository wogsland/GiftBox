<?php
include_once 'config.php';

_session_start();

$message = null;
$first_name = null;
$last_name = null;
$email = null;
$user_id = null;

if (logged_in()) {
    //header('Location: '.$app_root.'my_account.php');
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Gary Peters">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>GiveToken.com - Profile</title>

<!-- =========================
      FAV AND TOUCH ICONS

<link rel="icon" href="assets/img/favicon.ico">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-touch-icon-114x114.png">
============================== -->

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



<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
<![endif]-->

<!-- JQUERY -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- REACT -->
<script src="/js/react.js"></script>
<script src="/js/JSXTransformer.js"></script>

</head>

<body id="profile-page">
<!-- =========================
     PRE LOADER
============================== -->

<div class="preloader" >
  <div class="status">&nbsp;</div>
</div>


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
					<li><a href="profile.php" class="external">My Account</a></li>
					<li><a href="#">Login</a></li>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->

</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     ACCOUNT PROFILE
============================== -->

<script type="text/javascript" src="https://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/md5.js"></script>
<script type="text/javascript" src="/app/models/model.js"></script>
<script type="text/jsx" src="/app/account/AccountStore.js"></script>

<!-- React Components -->
<script type="text/jsx" src="/app/account/profile.js"></script>
<script type="text/jsx" src="/app/account/activities.js"></script>
<script type="text/jsx" src="/app/account/tokens.js"></script>
<script type="text/jsx" src="/app/account/token_analytics.js"></script>
<script type="text/jsx" src="/app/account/viewers.js"></script>
<script type="text/jsx" src="/app/account/viewer_edit.js"></script>
<script type="text/jsx" src="/app/account/info.js"></script>
<script type="text/jsx" src="/app/account/users.js"></script>
<script type="text/jsx" src="/app/account/user_edit.js"></script>
<script type="text/jsx" src="/app/account/user_remove.js"></script>
<script type="text/jsx" src="/app/account/index.js"></script>


<section class="profile" id="account-profile"></section>
<script type="text/jsx">
  React.render(<Account model={Model} />, document.getElementById('account-profile'));
</script>


<!-- =========================
     FOOTER
============================== -->
<footer id="contact" class="deep-dark-bg">

<div class="container">
	<div class="verticleHeight40"></div>
	<!-- LOGO -->
	<img src="assets/img/logo-light.png" alt="LOGO" class="responsive-img">

	<!-- SOCIAL ICONS -->
	<ul class="social-icons">
		<li><a href="#"><i class="social_facebook_square"></i></a></li>
		<li><a href="#"><i class="social_twitter_square"></i></a></li>
		<li><a href="#"><i class="social_pinterest_square"></i></a></li>
		<li><a href="#"><i class="social_googleplus_square"></i></a></li>
		<li><a href="#"><i class="social_instagram_square"></i></a></li>
		<li><a href="#"><i class="social_flickr_square"></i></a></li>
	</ul>

	<!-- COPYRIGHT TEXT -->
	<p class="copyright">
		©2015 GiveToken.com &amp; Giftly Inc., All Rights Reserved
	</p>

</div>
<!-- /END CONTAINER -->

</footer>
<!-- /END FOOTER -->


<!-- =========================
     SCRIPTS
============================== -->
<!--
<script>
		function add(text){
	    var TheTextBox = document.getElementById("Mytextbox");
	    TheTextBox.value = TheTextBox.value + text;
		}

</script>
-->

<script src="js/bootstrap.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.localScroll.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/nivo-lightbox.min.js"></script>
<script src="js/simple-expand.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/retina-1.1.0.min.js"></script>
<script src="js/jquery.nav.js"></script>
<script src="js/matchMedia.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.fitvids.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
