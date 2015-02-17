<?php
	include_once 'util.php';
	include_once 'config.php';
	zebra_session_start();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Maverick Blair & Co. | www.maverickblair.com">
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

<link rel="stylesheet" href="css/magnific-popup.css">


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
					<li><a href="index.html#brief1">How It Works?</a></li>
					<li><a href="index.html#screenshot-section">Examples</a></li>
					<li><a href="pricing.html" class="external">Pricing</a></li>
					<li><a href="index.html#contact">Contact</a></li>
					<?php
					if (logged_in()) {
						echo '<li><a href="javascript:void(0)" onclick="logout();">Logout</a></li>';
						echo '<li><a href="my_account.php" class="external">My Account</a></li>';
						if (is_admin()) {
							echo '<li><a href="admin.php">Admin</a></li>';
						}
					} else {
						echo '<li><a class="open-popup-link" id="login-link" href="#login-form" data-effect="mfp-3d-unfold">Login</a></li>';
						echo '<li><a class="open-popup-link" id="signup-link" href="#signup-form" data-effect="mfp-3d-unfold">Sign Up</a></li>';
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
					<h5>Send your next gift with GiveToken!</h5>
					
					<!-- BUTTON -->
					<div class="buttons" id="login-button">
						<?php
						if (logged_in()) {
							echo '<a href="create.php" class="btn btn-default btn-lg standard-button"><i class="icon_gift"></i>Create Token</a>';
						} else {
							echo '<a href="#login-form" class="open-popup-link btn btn-default btn-lg standard-button"><i class="icon_key"></i>Login</a>';
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
		<h2 class="white-text">Amazing Features!</h2>
		
		<div class="colored-line">
		</div>
		<div class="section-description">
			Go ahead, we got you covered. Our team is working hard to roll out more features everyday. Hover below to learn about what we current offer.
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
				<i class="icon_gift_alt"></i>
			</div>
			
			<!-- SERVICE HEADING -->
			<h3>More Than Just A Gift</h3>
			
			<!-- SERVICE DESCRIPTION -->
			<p>
				 Customize any digital gift with personal stories. Just like how you would decorate a real gift.
			</p>
			
		</div>
		<!-- /END SINGLE SERVICE -->
		
		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
			
			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_search"></i>
			</div>
			
			<!-- SERVICE HEADING -->
			<h3>Search Our Library</h3>
			
			<!-- SERVICE DESCRIPTION -->
			<p>
				 Find the right band, gift, card, or ebook in our huge database.
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
				<i class="icon_currency"></i>
			</div>
			
			<!-- SERVICE HEADING -->
			<h3>Great Value</h3>
			
			<!-- SERVICE DESCRIPTION -->
			<p>
				 Our service is completely free. Only pay for the gift itself.
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
			<h3>Content</h3>
			
			<!-- SERVICE DESCRIPTION -->
			<p>
				 Fill the GiveToken with singles, albums, ebooks, giftcards, and more!
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
		
		<!-- PHONES IMAGE -->
		<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
			<div class="video-container">
				
        <div class="video">
	        <iframe src="//player.vimeo.com/video/57175742?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=5ebb47" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
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
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br/><br/>
				Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
			</p>
			
			
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
					<h2 class="white-text">More than just a gift</h2>
					
					<div class="white-line-left">
					</div>
					
					<p class="white-text">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br/><br/>
						Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
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
					<h2 class="dark-text">More than just a gift</h2>
					
					<div class="colored-line-left">
					</div>
					
					<p class="dark-text">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br/><br/>
						Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
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
					<h2 class="white-text">More than just a gift</h2>
					
					<div class="white-line-left">
					</div>
					
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br/><br/>
						Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
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
			Lorem ipsum dolor kadr
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
<footer id="contact" class="deep-dark-bg">

<div class="container">
	
	<div class="contact-box wow rotateIn animated" data-wow-offset="10" data-wow-duration="1.5s">
		
		<!-- CONTACT BUTTON TO EXPAND OR COLLAPSE FORM -->
		
		<a class="btn contact-button expand-form expanded"><i class="icon_mail_alt"></i></a>
		
		<!-- EXPANDED CONTACT FORM -->
		<div class="row expanded-contact-form">
			
			<div class="col-md-8 col-md-offset-2">
				
				<!-- FORM -->
				<form class="contact-form" id="contact" role="form">
					
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
						<textarea class="form-control textarea-box" id="message" rows="8" placeholder="Message"></textarea>
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
		<li><a href="#"><i class="social_facebook_square"></i></a></li>
		<li><a href="#"><i class="social_twitter_square"></i></a></li>
		<li><a href="#"><i class="social_pinterest_square"></i></a></li>
		<li><a href="#"><i class="social_googleplus_square"></i></a></li>
		<li><a href="#"><i class="social_instagram_square"></i></a></li>
		<li><a href="#"><i class="social_flickr_square"></i></a></li>
	</ul>
	
	<!-- COPYRIGHT TEXT -->
	<p class="copyright">
		©2014 GiveToken.com &amp; Giftly Inc., All Rights Reserved
	</p>

</div>
<!-- /END CONTAINER -->
 
</footer>
<!-- /END FOOTER -->

<form id="login-form" class="white-popup mfp-hide" name="login-form">
	<h1 class="dialog-header">Log Into Giftbox</h1>
	<div id="dialog-form-container">
		<p class="dialog-message" id="login-message"></p>
		<input type="hidden" name="login-type" value="EMAIL">
		<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="25">
		<input class="dialog-input" id="password" name="password" type="password" placeholder="Password" size="25">
		<a id="forgot-password" href="javascript:void(0)" onClick="forgotPassword()">Forgot your password?</a>
		<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="FB.login(function(response){handleFBLogin(response)}, {scope: 'public_profile, email'});">Log In with Facebook</a>
		<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="login(document.forms['login-form']);">Log In</a>
	</div>
</form>

<form id="signup-form" class="white-popup mfp-hide" name="signup-form">
	<h1 class="dialog-header">Sign Up With Giftbox</h1>
	<div id="dialog-form-container">
		<p class="dialog-message" id="signup-message"></p>
		<input type="hidden" id="reg_type" name="reg_type" value="">
		<input class="dialog-input" id="first_name" name="first_name" type="text" placeholder="First Name" size="20">
		<input class="dialog-input" id="last_name" name="last_name" type="text" placeholder="Last Name" size="20">
		<input class="dialog-input" id="email" name="email" type="text" placeholder="Your Email" size="35">
		<input class="dialog-input" id="password" name="password" type="password" placeholder="New Password" size="35">
		<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="FB.login(function(response){handleFBReg(response)}, {scope: 'public_profile, email'});">Sign Up Using Facebook</a>
		<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="var a = document.forms['signup-form']; register(a.first-name.value, a.last-name.value, a.email.value, a.password.value);">Sign Up</a>
	</div>
</form>


<!-- =========================
     SCRIPTS 
============================== -->
<script>
		function add(text){
	    var TheTextBox = document.getElementById("Mytextbox");
	    TheTextBox.value = TheTextBox.value + text;
		}
	
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
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/facebook_init.js"></script>
<script src="js/scripts.js"></script>
<script src="js/account.js"></script>

</body>
</html>
