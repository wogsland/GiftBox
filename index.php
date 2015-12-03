<?php
require_once __DIR__.'/config.php';

define('TITLE', 'GiveToken.com - Create your next message with GiveToken');
require __DIR__.'/header.php';
?>

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
    <?php require_once "analyticstracking.php"; ?>

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

    <?php require __DIR__.'/navbar.php';?>

	<!-- CONTAINER -->
	<div class="container">

		<!-- ONLY LOGO ON HEADER -->
		<div class="only-logo">
			<div class="navbar">
<!-- 				<div class="navbar-header">
					<img src="/assets/img/logo-light.png" alt="">
				</div> -->
			</div>
		</div> <!-- /END ONLY LOGO ON HEADER -->


		<div class="row">
			<div class="col-md-8 col-md-offset-2">

				<!-- HEADING AND BUTTONS -->
				<div class="intro-section">

					<!-- WELCOM MESSAGE -->
					<h1 class="intro">Candidate Engagement</h1>
					<h5>Recruiting in a matter of minutes</h5>

					<!-- BUTTON -->
					<div class="buttons" id="login-button">
        <?php
        if (logged_in()) {
            echo '<a href="/token_type" class="btn btn-default btn-lg standard-button"><i class="icon_gift"></i>Create Token</a>';
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

			<div class="col-md-12 col-md-offset-1 macbook"><img class="img-responsive" src="/assets/img/macbook01.png" alt="GiveToken Screenshot"></div>
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
			We give you the tools to add everything and anything to your next Token Creation.
		</div>
		<div class="section-description">
			Go ahead, we’ve got you covered. See how our features can help you create a Token Creation you’ll love to share.
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
				<i class="icon_film"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Videos</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Don't just give information to recruits, show them something!
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
				 Pictures are worth 1000 words, use them to connect with a candidate.
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
			<h3>Text</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				Some details are just too important to leave out, so don't forget to make it personal.
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
				<i class="icon_mail"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Attachments</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Add an offer letter or job details to complete the interaction.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

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
				 Make the message interactive by using links to show more about the company and opportunity.
			</p>

		</div>
		<!-- /END SINGLE SERVICE -->

		<!-- SINGLE SERVICE -->
		<div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SERVICE ICON -->
			<div class="service-icon">
				<i class="icon_gift"></i>
			</div>

			<!-- SERVICE HEADING -->
			<h3>Wrapper</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Utilize our interactive wrappers to invite the candidate into the recruiting experience.
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
			<h3>Analytics</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				 Verify what messages work and what leaves something to be desired.
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
			<h3>Sharable</h3>

			<!-- SERVICE DESCRIPTION -->
			<p>
				Reach a candidate with any form of messaging, whether thats email, text, or social media.
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
			<h2 class="white-text">Tell Your Story</h2>

			<div class="white-line-left">
			</div>

			<p class="white-text">
				With GiveToken, recruiters combine multi-media content with a personal message to connect with candidates and fill job openings faster and more efficiently.
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
					<img class="img-responsive" src="/assets/img/token-ipad.png" alt="token-ipad" width="585" height="418">
				</div>

				<!-- RIGHT SIDE WITH BRIEF -->
				<div class="col-md-6 left-align wow fadeInLeft animated deep-grey-bg" data-wow-offset="10" data-wow-duration="1.5s">
					<!-- SECTION TITLE -->
					<h2 class="white-text">Sell the Job</h2>

					<div class="white-line-left">
					</div>

					<p class="white-text">
						The candidate is engaged and wants to hear more about the job. It's time to combine pictures, videos, text and attachments to show the candidate the kind of job and company that they have been searching for.
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
					<h2 class="dark-text">Put a bow on it</h2>

					<div class="colored-line-left">
					</div>

					<p class="dark-text">
						Candidates want personalization, not just a salary and set of skills. Using our "wrapper" functionality, create a message that stands out from other recruiters and other opportunities.
					</p>


				</div>
				<!-- /END LEFT BRIEF -->

				<div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
					<img class="img-responsive" src="/assets/img/token-iphone-cropped.png" alt="token-iphone-cropped">
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
					<img class="img-responsive" src="/assets/img/token-macbook.png" alt="token-macbook" width="585" height="311">
				</div>

				<!-- RIGHT SIDE WITH BRIEF -->
				<div class="col-md-6 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

					<!-- SECTION TITLE -->
					<h2 class="white-text">Figure out what works</h2>

					<div class="white-line-left">
					</div>

					<p>
						Recruiters send hundreds of messages and need a way to track the success of each message. GiveToken provides an analytics package that allows the recruiter to see what candidates actually engage with.
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
				<a href="/assets/img/tokens/acentertainment.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/acentertainment.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/boca-hh.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/boca-hh.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/fedex.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/fedex.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/home-depot.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/home-depot.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/office-depot.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/office-depot.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/second-harvest.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/second-harvest.jpg" alt="Screenshot"></a>
			</div>

			<div class="shot">
				<a href="/assets/img/tokens/stjudes.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/img/tokens/stjudes.jpg" alt="Screenshot"></a>
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
						<textarea class="form-control textarea-box" id="message" name="message" rows="8" placeholder="Message"></textarea>
					</div>

					<button class="btn btn-primary btn-lg" id="send-message-button" onclick="sendMessage(event); return false;">Send Message</button>

				</form>
				<!-- /END FORM -->

			</div>

		</div>
		<!-- /END EXPANDED CONTACT FORM -->

	</div>
	<!-- /END CONTACT BOX -->

</div>
<!-- /END CONTAINER -->

<?php require __DIR__.'/footer.php';?>

<!-- =========================
    PAGE SPECIFIC SCRIPTS
============================== -->
<script src="/js/contact.js?v=<?php echo VERSION;?>"></script>
<script>
$(document).ready(function(){
  url = '/ajax/slackbot/<?php echo $_SERVER['REMOTE_ADDR'];?>';
  $.post(url);
});
</script>

</body>
</html>
