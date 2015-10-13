<?php
use \GiveToken\Token;
use google\appengine\api\cloud_storage\CloudStorageTools;

include_once 'config.php';
include_once 'analyticsauth.php';
include_once 'analyticsqueries.php';

_session_start();

$message = null;
$first_name = null;
$last_name = null;
$email = null;
$user_id = null;

$token = new Token($_GET['id']);

if ($google_app_engine) {
    $token->image_path = CloudStorageTools::getPublicUrl($file_storage_path.$token->thumbnail_name, $use_https);
} else {
    $token->image_path = $file_storage_path.$token->thumbnail_name;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Genevieve Tran">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>GiveToken.com - Analytics</title>

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

<!-- COLORS -->
<link rel="stylesheet" href="css/colors.css">

<!-- RESPONSIVE FIXES -->
<link rel="stylesheet" href="css/responsive.css">

<!-- CUSTOM STYLESHEETS -->
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.vertical-tabs.min.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/analytics.css">

<!-- JQUERY -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="js/draw.js"></script>

</head>

<body id="analytics-page">
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

<div class="container">
	<div class="main-body">
		<div class="row">
			<div class="col-sm-4" id="thumbnail">
				<h3><?= $token->name; ?></h3>
				<?= "<img src=". $token->image_path .">" ;?>
			</div>
			<div class="col-sm-6" id="generalInfo">
				<ul class="list-group">
				  <li class="list-group-item odd"><h4>Total Views: <?= printResults($numTotalResults); ?></h4></li>
				  <li class="list-group-item"><h4>Unique Views: <?= printResults($numUniqueResults); ?></h4></li>
				  <li class="list-group-item odd"><h4>Average Time on the Token: <?= printTimeResults($numAverageResults); ?></h4></li>
				  <li class="list-group-item"><h4>Bounces: <?= printBounceResults($numBouncesResults); ?></h4></li>
				</ul>
<!-- 				<h3>Total Views: <?= printResults($numTotalResults); ?></h3>
				<h3>Unique Views: <?= printResults($numUniqueResults); ?></h3>
				<h3>Average Time on the Token: <?= printTimeResults($numAverageResults); ?></h3>
				<h3>Bounces: <?= printResults($numBouncesResults); ?></h3> -->
			</div>
		</div>
		<div class="row" id="analytics-panel">

			<div class="col-xs-2"> <!-- required for floating -->
			    <!-- Nav tabs -->
			    <ul class="nav nav-tabs tabs-left">
			      <li class="active"><a href="#general" data-toggle="tab">General</a></li>
			      <li><a href="#social" data-toggle="tab">Social Media</a></li>
			      <li><a href="#audience" data-toggle="tab">Audience</a></li>
			      <li><a href="#technology" data-toggle="tab">Technology</a></li>
			      <li class="disabled"><a>Popular Trends <span class="soon">(coming soon)</span></a></li>
			      <li class="disabled"><a>Custom Search <span class="soon">(coming soon)</span></a></li>
			    </ul>
			</div>

			<div class="col-xs-10">
			    <!-- Tab panes -->
			    <div class="tab-content">

			      <div class="tab-pane active" id="general">
			      		<div class="col-sm-6">

			            <section id="total-timeline"></section>
			              <script>
			              totalChartData = <?php
			                  echo json_encode($totalResults->getDataTable()->toSimpleObject())
			              ?>;
			              totalChartNumber = "<?= printResults($numTotalResults); ?>";
			              </script>

			            <section id="unique-timeline"></section>
			              <script>
			              uniqueChartData = <?php
			                  echo json_encode($uniqueResults->getDataTable()->toSimpleObject())
			              ?>;
			              uniqueChartNumber = "<?= printResults($numUniqueResults); ?>";
			              </script>

			          </div>
			          <div class="col-sm-6">

			            <section id="average-time-timeline"></section>
			              <script>
			              averageChartData = <?php
			                  echo json_encode($averageResults->getDataTable()->toSimpleObject())
			              ?>;
			              averageChartNumber = "<?= printTimeResults($numAverageResults); ?>";
			              </script>

			            <section id="bounces-timeline"></section>
			              <script>
			              bouncesChartData = <?php
			                  echo json_encode($bouncesResults->getDataTable()->toSimpleObject())
			              ?>;
			              bouncesChartNumber = "<?= printBounceResults($numBouncesResults); ?>";
			              </script>

			          </div>
			      </div>

			      <div class="tab-pane" id="social">
			      		<div class="col-sm-6">

			            <section id="facebook-timeline"></section>
			              <script>
			              facebookChartData = <?php
			                  echo json_encode($facebookResults->getDataTable()->toSimpleObject())
			              ?>;
			              facebookChartNumber = "<?= printResults($numFacebookResults); ?>";
			              </script>

			            <section id="twitter-timeline"></section>
			              <script>
			              twitterChartData = <?php
			                  echo json_encode($twitterResults->getDataTable()->toSimpleObject())
			              ?>;
			              twitterChartNumber = "<?= printBounceResults($numTwitterResults); ?>";
			              </script>
			             <!-- twitterChartNumber = "<?= printResults($numTwitterResults); ?>"; -->


			          	</div>
			          	<div class="col-sm-6">

				            <section id="email-timeline"></section>
				              <script>
				              emailChartData = <?php
				                  echo json_encode($emailResults->getDataTable()->toSimpleObject())
				              ?>;
				              emailChartNumber = "<?= printResults($numEmailResults); ?>";
				              </script>
			          	</div>
			      </div>


			      <div class="tab-pane" id="audience">
			      	<div class="row">
			      		<div class="col-sm-6">
			            <section id="gender-timeline"></section>
			              <script>
			              genderChartData = <?php
			                  echo json_encode($genderResults->getDataTable()->toSimpleObject())
			              ?>;
			              </script>
			            </div>
			            <div class="col-sm-6">
			            <section id="age-timeline"></section>
			              <script>
			              ageChartData = <?php
			                  echo json_encode($ageResults->getDataTable()->toSimpleObject())
			              ?>;
			              </script>
			            </div>
			        </div>
		            <div class="row">
		            	<div class="col-sm-6 col-sm-offset-3">
		            	<p>Cities</p>
		            	<section id="geo-timeline"></section>
			              <script>
			              geoChartData = <?php
			                  echo json_encode($geoResults->getDataTable()->toSimpleObject())
			              ?>;
			              </script>
		            	</div>
		            </div>
			      </div>


			      <div class="tab-pane" id="technology">
			      		<div class="row">
				      		<div class="col-sm-6">

				            <section id="device-timeline"></section>
				              <script>
				              deviceChartData = <?php
				                  echo json_encode($deviceResults->getDataTable()->toSimpleObject())
				              ?>;
				              </script>

				            <section id="desktop-timeline"></section>
				              <script>
				              desktopChartData = <?php
				                  echo json_encode($desktopResults->getDataTable()->toSimpleObject())
				              ?>;
				              desktopChartNumber = "<?= printResults($numDesktopResults); ?>";
				              </script>

				            </div>
				            <div class="col-sm-6">

				            <section id="tablet-timeline"></section>
				              <script>
				              tabletChartData = <?php
				                  echo json_encode($tabletResults->getDataTable()->toSimpleObject())
				              ?>;
				              tabletChartNumber = "<?= printResults($numTabletResults); ?>";
				              </script>

				            <section id="mobile-timeline"></section>
				              <script>
				              mobileChartData = <?php
				                  echo json_encode($mobileResults->getDataTable()->toSimpleObject())
				              ?>;
				              mobileChartNumber = "<?= printResults($numMobileResults); ?>";
				              </script>
				              				            </div>
				        </div>
			      </div>
			    </div>
			</div>
		</div>
	</div>
</div>

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
