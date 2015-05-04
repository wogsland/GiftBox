<?php
	include_once 'util.php';
	include_once 'config.php';
	_session_start();
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
<title>GiveToken.com - Give a Token of Appreciation</title>

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

<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />

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

<script>
	function changePage(event) {
    if($(event.target).hasClass('external')) {
        window.location.href = $(event.target).attr('href');
        return;
    }
	}

	$(function () {
	    $('.nav li').click( changePage );
	})
</script>

</head>

<body>
	<?php include_once("analyticstracking.php") ?>

<!-- =========================
     PRE LOADER
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="home">

<!-- SOLID COLOR BG -->
<div class="deep-dark-bg"> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->

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

				<a class="navbar-brand" href="<?php echo $app_root ?>"><img src="assets/img/logo-light.png" alt=""></a>

			</div>

			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="kane-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<li><a href="index.html#home">Home</a></li>
					<li><a href="index.html#features">Features</a></li>
					<li><a href="community.php" class="external">Community</a></li>
					<li><a href="index.html#brief1">How It Works?</a></li>
					<li><a href="index.html#screenshot-section">Examples</a></li>
					<li><a href="pricing.php" class="external">Pricing</a></li>
					<li><a href="index.html#contact">Contact</a></li>
					<?php
					if (logged_in()) {
						echo '<li><a href="javascript:void(0)" onclick="logout();">Logout</a></li>';
						echo '<li><a href="profile.php" class="external">My Account</a></li>';
						if (is_admin()) {
							echo '<li><a href="admin.php" class="external">Admin</a></li>';
						}
					} else {
						echo '<li><a href="javascript:void(0)" onclick="$(\'#login-dialog\').modal()">Login</a></li>';
						echo '<li><a href="javascript:void(0)" onclick="$(\'#signup-dialog\').modal()">Sign Up</a></li>';
					}
					?>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->


	<!-- CONTAINER -->
	<div class="container">

		<!-- ONLY LOGO ON HEADER -->
		<div class="only-logo">
			<div class="navbar">
				<div class="navbar-header">
					<img src="assets/img/logo-light.png" alt="">
				</div>
			</div>
		</div> <!-- /END ONLY LOGO ON HEADER -->


		<div class="row">
			<div class="col-md-8 col-md-offset-2">

				<!-- HEADING AND BUTTONS -->
				<div class="intro-section">

					<!-- WELCOM MESSAGE -->
					<h1 class="intro">Give a Token of Appreciation</h1>
					<h5>Send your next message with GiveToken</h5>

					<!-- BUTTON -->
					<div class="buttons" id="login-button">
						<?php
						if (logged_in()) {
							echo '<a href="create.php" class="btn btn-default btn-lg standard-button"><i class="icon_gift"></i>Create Token</a>';
						} else {
							echo '<a href="javascript:void(0)" class="btn btn-default btn-lg standard-button" onclick="signupOpen(1)"><i class="icon_pencil"></i>Sign Up</a>';
							echo ' or ';
							echo '<a href="javascript:void(0)" class="btn btn-default btn-lg standard-button" onclick="loginOpen()"><i class="icon_key"></i>Login</a>';
						}
						?>
					</div>
					<!-- /END BUTTONS -->

				</div>
				<!-- /END HEADNING AND BUTTONS -->

			</div>

			<div class="col-md-12 col-md-offset-1 macbook"><img class="img-responsive" src="assets/img/macbook01.jpg" alt="GiveToken Screenshot"></div>
		</div>
		<!-- /END ROW -->

	</div>
	<!-- /END CONTAINER -->
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     FEATURES
============================== -->
<section class="features" id="features">

<div class="container">

	<!-- SECTION HEADER -->
	<div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

		<!-- SECTION TITLE -->
		<h2 class="white-text">Amazing Features</h2>

		<div class="colored-line">
		</div>
		<div class="section-description">
			Go ahead, we got you covered. See how our features can help you create a token you’ll love to share.
		</div>
		<div class="colored-line">
		</div>

	</div>
	<!-- /END SECTION HEADER -->

	<div class="row">

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_link"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Links</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Token can take you anywhere. We’ll show you how to embed links wherever you need them.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_music"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Music</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Load up your token with just the right soundtrack.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_pencil-edit"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Customize</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Completely customizable for that personal touch.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

	</div>
	<!-- /END ROW -->

	<div class="row">

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_film"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Video</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Sometimes they just have to see it. Token has plenty of space for your “you­-just-­had-­to-be­-there” moments.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="social_facebook"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Social Media</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Search your social media or upload pictures, videos, or notes. Then add them to your personal library.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_images"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Images</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 We give you space to cover your token with photos of any shape and size.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

	</div>
	<!-- /END ROW -->

	<!--Third Row -->
	<div class="row">

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_grid-2x2"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Collage</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 GiveToken lets you package content into a dynamic collage, to add that personal touch.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_quotations_alt"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Text & Quotes</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				Never underestimate the power of words. Personalize your token with text of your own.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_cloud-upload"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Share on any Platform</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				Once your token looks just the way you want it, we make it simple to share.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

	</div>
	<!-- /END ROW -->

</div>
<!-- /END CONTAINER -->

</section>
<!-- /END FEATURES SECTION -->


<!-- =========================
     BRIEF LEFT SECTION WITH VIDEO
============================== -->
<section class="app-brief solid-green" id="brief1" style="border-bottom: 20px solid #222222;">

<div class="container">

	<div class="row">

		<!-- PHONES IMAGE >-->
		<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
			<div class="video-container">

        <div class="video">
			<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		</div>

			</div>
		</div>

		<!-- RIGHT SIDE WITH BRIEF -->
		<div class="col-md-6 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SECTION TITLE -->
			<h2 class="white-text">How it Works</h2>

			<div class="white-line-left">
			</div>

			<p class="white-text">
				GiveToken is your blank canvas to create a personalized virtual postcard.
			</p>
			<ul class="white-text">
 				<li>Customize your token with a unique mix of videos, music, photos and more</li>
 				<li>Click and drag media from your computer or from anywhere on the web</li>
 				<li>Share your token on any platform with just a simple link</li>
 				<li>Make it personal and send your token to a specific person or group</li>
			</ul>



		</div>
		<!-- /END RIGHT BRIEF -->

	</div>
	<!-- /END ROW -->

</div>
<!-- /END CONTAINER -->

</section>
<!-- /END SECTION -->

<!-- =========================
     SAMPLE IPAD
============================== -->
<section class="token-ipad solid-lt-green" id="token-ipad" style="border-bottom: 20px solid #222222;">

	<div class="">
		<div class="container">
			<div class="row">

				<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
					<img class="img-responsive" src="assets/img/token-ipad.png" alt="token-ipad" width="585" height="418">
				</div>

				<!-- RIGHT SIDE WITH BRIEF -->
				<div class="col-md-6 left-align wow fadeInLeft animated deep-grey-bg" data-wow-offset="10" data-wow-duration="1.5s">

					<!-- SECTION TITLE -->
					<h2 class="white-text">GiveToken is connecting</h2>

					<div class="white-line-left">
					</div>

					<p class="white-text">
					You know those “you just had to be there” moments? Your fans and friends know them too. With our help, you can combine the best clips and sounds from the night in one personalized token to share with fans. The best part? Your fans can share the same token with anyone who missed the epic show. We help you break through that barrier and build more personal relationships with the people who truly matter.
					</p>


				</div>
				<!-- /END RIGHT BRIEF -->

			</div>
		</div>
	</div>

</section>
<!-- /END SAMPLE IPAD SECTION -->

<!-- =========================
     SAMPLE IPHONE
============================== -->
<section class="token-iphone solid-lt-blue" id="token-iphone" style="border-bottom: 20px solid #222222;">

	<div class="">
		<div class="container">
			<div class="row">

				<!-- LEFT SIDE WITH BRIEF -->
				<div class="col-md-6 left-align wow fadeInLeft animated" style="margin-top: 15%;" data-wow-offset="10" data-wow-duration="1.5s">

					<!-- SECTION TITLE -->
					<h2 class="dark-text">GiveToken is sharing</h2>

					<div class="colored-line-left">
					</div>

					<p class="dark-text">
						We’ll help you design a token for any event, like a company service day, so you can look back at the day’s highlights. Share the token with everyone who was there, and they can show their own friends and family what they missed.
					</p>


				</div>
				<!-- /END LEFT BRIEF -->

				<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
					<img class="img-responsive" src="assets/img/token-iphone-cropped.png" alt="token-iphone-cropped" width="585" height="794">
				</div>

			</div>
		</div>
	</div>

</section>
<!-- /END SAMPLE IPAD SECTION -->

<!-- =========================
     SAMPLE MACBOOK
============================== -->
<section class="token-macbook solid-blue" id="token-macbook">

	<div class="">
		<div class="container">
			<div class="row">

				<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
					<img class="img-responsive" src="assets/img/token-macbook.png" alt="token-macbook" width="585" height="311">
				</div>

				<!-- RIGHT SIDE WITH BRIEF -->
				<div class="col-md-6 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

					<!-- SECTION TITLE -->
					<h2 class="white-text">GiveToken is short and sweet</h2>

					<div class="white-line-left">
					</div>

					<p>
						We all know the best way to share a lot of information in the simplest way is through images. Tokens combine both visuals and sounds to create a compact, shareable gift for the most impact.
					</p>


				</div>
				<!-- /END RIGHT BRIEF -->

			</div>
		</div>
	</div>

</section>
<!-- /END SAMPLE IPAD SECTION -->


<!-- =========================
     SCREENSHOTS
============================== -->
<section class="screenshots" id="screenshot-section">

<div class="container">


	<div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">


		<h2 class="white-text">Token Examples</h2>

		<div class="colored-line">
		</div>
		<div class="section-description">
			Friends of GiveToken
		</div>
		<div class="colored-line">
		</div>

	</div>


	<div class="row wow bounceIn animated" data-wow-offset="10" data-wow-duration="1.5s">

		<div id="screenshots" class="owl-carousel owl-theme">

			<div class="shot">
				<a href="assets/img/tokens/acentertainment.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/acentertainment.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/boca-hh.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/boca-hh.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/fedex.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/fedex.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/home-depot.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/home-depot.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/office-depot.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/office-depot.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/second-harvest.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/second-harvest.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="assets/img/tokens/stjudes.jpg" data-lightbox-gallery="screenshots-gallery"><img src="assets/img/tokens/stjudes.jpg" alt="Screenshot"></a>
			</div>

		</div>


	</div>


</div>


</section>

<!-- =========================
     FOOTER
============================== -->
<footer id="contact-footer" class="deep-dark-bg">

<div class="container">

	<div class="contact-box wow rotateIn animated" data-wow-offset="10" data-wow-duration="1.5s">

		<!-- CONTACT BUTTON TO EXPAND OR COLLAPSE FORM -->

		<a class="btn contact-button expand-form expanded"><i class="icon_mail_alt"></i></a>

		<!-- EXPANDED CONTACT FORM -->
		<div class="row expanded-contact-form">

			<div class="col-md-8 col-md-offset-2">

				<!-- FORM -->
				<form class="contact-form" id="contact" role="form" action = "sendemail.php" method="POST">

					<!-- IF MAIL SENT SUCCESSFULLY -->
					<h4 class="success">
						<i class="icon_check"></i> Your message has been sent successfully.
					</h4>

				    <!-- IF MAIL SENDING UNSUCCESSFULL -->
					<h4 class="error">
						<i class="icon_error-circle_alt"></i> E-mail must be valid and message must be longer than 1 character.
					</h4>

					<div class="col-md-6">
						<input class="form-control input-box" id="name" type="text" name="name" placeholder="Your Name">
					</div>

					<div class="col-md-6">
						<input class="form-control input-box" id="email" type="email" name="email" placeholder="Your Email">
					</div>

					<div class="col-md-12">
						<input class="form-control input-box" id="subject" type="text" name="subject" placeholder="Subject">
						<textarea class="form-control textarea-box" id="message" name="message" rows="8" placeholder="Message"></textarea>
					</div>

					<button class="btn btn-primary standard-button2 ladda-button" type="submit" id="submit" name="submit" data-style="expand-left">Send Message</button>

				</form>
				<!-- /END FORM -->

			</div>

		</div>
		<!-- /END EXPANDED CONTACT FORM -->

	</div>
	<!-- /END CONTACT BOX -->

	<!-- LOGO -->
	<img src="assets/img/logo-light.png" alt="LOGO" class="responsive-img">

	<!-- SOCIAL ICONS -->
	<ul class="social-icons">
		<li><a href="https://www.facebook.com/givetokencom"><i class="social_facebook_square"></i></a></li>
		<li><a href="#"><i class="social_twitter_square"></i></a></li>
		<li><a href="#"><i class="social_pinterest_square"></i></a></li>
		<li><a href="#"><i class="social_googleplus_square"></i></a></li>
		<li><a href="#"><i class="social_instagram_square"></i></a></li>
		<li><a href="#"><i class="social_flickr_square"></i></a></li>
	</ul>

	<!--Terms and Policy-->
	<ul class="terms-policy">
		<li><a href="termsservice.php">Terms and Conditions</a></li>
		<li><a href="privacypolicy.php">Privacy Policy</a></li>
	</ul>



	<!-- COPYRIGHT TEXT -->
	<p class="copyright">
		©2014 GiveToken.com &amp; Giftly Inc., All Rights Reserved
	</p>

</div>
<!-- /END CONTAINER -->

</footer>
<!-- /END FOOTER -->

<!-- =========================
     SCRIPTS
============================== -->
<script>

(function() {

function isEmail( str ) {
    return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( str );
}

// When the user submits the contact form...
var contactForm = $( "#contact" ).on( "submit", function( event ) {
    // Prevent the form from actually submitting
    // We do this so that the user stays on the current page
    event.preventDefault();

    // Hide any messages from previous send attempts
    contactForm.find( ".success" ).hide();
    contactForm.find( ".error" ).hide();

    var name = $( "#name" ).val();
    var email = $( "#email" ).val();
    var subject = $( "#subject" ).val();
    var message = $( "#message" ).val();

    // If any field isn't filled in, show the error message and stop processing
    if ( !name.length || !isEmail(email) || !subject.length || !message.length ) {
        contactForm.find( ".error" ).show();
        return;
    }

    // Submit the form via Ajax
	$.post(
	    // Get the URL from the form
	    contactForm.attr("action"),
	    // Get the data from the form
	    contactForm.serialize(),
	    // Set up a callback for successfully posting the data
	    function(data, textStatus, jqXHR){
    		if(data.status === "SUCCESS") {
    		    contactForm.find( ".success" ).show();
    		} else if (data.status === "ERROR") {
    			// TODO
    			alert( "error1" );
    		} else {
    			// TODO
    			alert( "error2" );
    		}
	    }
	).fail(function() {
		// TODO
		alert( "error3" );
	});
});

})();

</script>
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
<script src="js/facebook_init.js"></script>
<script src="js/util.js"></script>
<script src="js/pay_with_stripe.js"></script>
<script src="js/login.js"></script>
<script src="js/signup.js"></script>
<script src="js/account.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

</body>
</html>
