<?php
use \GiveToken\User;

	include_once 'util.php';


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
<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />

<!-- BOOTSTRAP -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- FONT ICONS -->
<link rel="stylesheet" href="assets/elegant-icons/style.css">
<link rel="stylesheet" href="assets/app-icons/styles.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

<!-- WEB FONTS -->
<link href='https://fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic' rel='stylesheet' type='text/css'>

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
<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>

</head>

<body id="pricing-page">
<!-- =========================
     PRE LOADER
============================== -->
<div class="preloader">
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
					<?php
					if (logged_in()) {
						echo '<li><a href="my_account.php" class="external">My Account</a></li>';
					} else {
						echo '<li><a href="#">Login</a></li>';
					}
					?>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->

</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     PRICNG SECTION
============================== -->

<section class="" id="pricing-table">
	<div class="container mb30">
		<div class="pricing-tables attached">

        <h1 id="attached-narrow">Pricing Step One</h1>
        <div class="row">
          <div class="col-sm-3 col-md-3">

           <div class="plan first basic plan-hover" id="basic" data-plan="basic">

              <div class="head">
                <h2>Basic</h2>

              </div>

              <!-- button was here -->
              <div class="not-btn solid-blue"></div>

              <ul class="item-list">
								<li>Email Support</li>
								<li>The Core of Our Product</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
              </ul>

              <div class="price">
                <h3><span class="symbol"></span>Free</h3>
                <h4>per month</h4>
              </div>

              <div class="not-btn solid-blue">
				<?php
					if (logged_in()) {
						if (isset($_SESSION["level"]) && $_SESSION["level"] == 1) {
							echo 'Already a member!';
						}
					} else {
						echo '<button type="button" class="btn dark-grey" onclick="signupOpen(1)">Sign Up <i class="fa fa-chevron-right"></i></button>';
					}
				?>
			  </div>

           </div>


          </div>


			<div class="col-sm-3 col-md-3 ">
				<div class="plan standard plan-hover" id="standard" data-plan="standard">

					<div class="head">
						<h2>Standard</h2>
					</div>

					<div class="not-btn solid-lt-blue"></div>

					<ul class="item-list">
						<li>Email Support</li>
						<li>Open Saved Tokens</li>
						<li>Embed Link</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>

					<div class="price">
						<h3><span class="symbol">$</span>24.99</h3>
						<h4>per month</h4>
					</div>

					<div class="not-btn solid-lt-blue">
						<?php
							if (logged_in()) {
								if (isset($_SESSION["level"]) && $_SESSION["level"] == 2) {
									echo 'Already a member!';
								} else {
									$user = new User($_SESSION["user_id"]);
									echo '<button type="button" class="btn dark-grey" onclick="payWithStripe(\''.$user->email_address.'\', \'PRICING\')">Upgrade <i class="fa fa-chevron-right"></i></button>';
								}
							} else {
								echo '<button type="button" class="btn dark-grey" onclick="signupOpen(2)">Sign Up And Pay <i class="fa fa-chevron-right"></i></button>';
							}
						?>
					</div>
				</div>
			</div>


          <div class="col-sm-3 col-md-3 ">

              <div class="plan recommended plan-hover" id="premium" data-plan="premium">
<!--								<div class="popular-badge">MOST POPULAR</div>  -->
                <div class="head">
                  <h2>Premium</h2>
                </div>

		            <div class="select-btn solid-lt-green"></div>

                <ul class="item-list">
									<li>8 HR Response Support</li>
									<li>Open Saved Tokens</li>
									<li>Embed Link</li>
									<li>Letter Formatting</li>
									<li>Analytics</li>
									<li>Advanced Send</li>
									<li>Animation Opener</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
                </ul>

                <div class="price">
                  <h3><span class="symbol">$</span>74.99</h3>
                  <h4>per month + step 2</h4>
                </div>

                <div class="select-btn solid-lt-green"><button type="button" class="btn dark-grey">Pre-Order <i class="fa fa-chevron-right"></i></button></div>

           </div>

          </div>

          <div class="col-sm-3 col-md-3 ">

              <div class="plan last enterprise plan-hover" id="enterprise" data-plan="enterprise">

                <div class="head">
                  <h2>Enterprise</h2>
                </div>

		            <div class="select-btn solid-green"></div>

                <ul class="item-list">
									<li>24/7 Response Support</li>
									<li>Open Saved Tokens</li>
									<li>Embed Link</li>
									<li>Custom Letter Formatting</li>
									<li>Advanced Analytics</li>
									<li>Advanced Send</li>
									<li>Custom Animation Opener</li>
									<li>Enterprise Shareable Library</li>
									<li>Token Collections</li>
                </ul>

                <div class="price">
                  <h3><span class="symbol">$</span>120</h3>
                  <h4>per user per month + step 2 + step 3</h4>
                </div>

                <div class="select-btn solid-green"><button type="button" class="btn dark-grey">Pre-Order <i class="fa fa-chevron-right"></i></button></div>

           </div>

          </div>

        </div> <!-- row-->

      </div>
	</div><!-- /contentpanel -->
</section>

<!-- Section for choosing Trackable Viewers-->
<section class="pricingChart not" id="pricingChart">
	<div class="container">
		<div class="verticleHeight40"></div>
		<h1 id="attached-narrow">Pricing Step Two -- Number of Trackable Viewers</h1>
		<div class="row pricingChart" id="getStarted">
      		<div class="span12 text-center clearfix">
          		<div class="pricingLevel " id="pricing500" data-viewer="500">
              		<div class="pricingImage"></div>
              		1-500
          		</div>

          		<div class="pricingLevel pricing2500" id="pricing2500" data-viewer="2500">
              		<div class="pricingImage"></div>
              		501-<span>2,500</span>
          		</div>

          		<div class="pricingLevel pricing5000" id="pricing5000" data-viewer="5000">
              		<div class="pricingImage"></div>
              		2,501-<span>5,000</span>
          		</div>
	</div>
</section>



<!-- =========================
     FOOTER
============================== -->
<footer id="contact" class="deep-dark-bg mt20">

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

<!-- These modals will be deleted when Stripe is used -->

<div class="modal fade"  id="premium-dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class ="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="gridSystemModalLabel"><b>Pre-order</b></h3>
			</div>
			<div class ="modal-body">
				<center>
					<h3>Please contact Robbie Zettler at</h3>
					<a href="mailto:rzettler@givetoken.com?Subject=Givetoken%20pricing" target="_top"><h3><b>rzettler@givetoken.com</b></h3></a>
				</center>
			</div>
			<div class ="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal 2-->

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="myModal2">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class ="modal-header">
        Plan Type
      </div>
      <div class ="modal-body">
        Options
        <!-- Change so that this links to the log in -->
        <button type="button" class="btn btn-default" data-dismiss="modal">Log In</button>
        <!-- Change so that this links to the sign up -->
        <button type="button" class="btn btn-default" data-dismiss="modal">Sign Up</button>
        <p>
          Thanks for looking at GiveToken! Pardon the dust as we add in the latest features. Please reach out to us we would love to talk to you!
        </p>
        <p>
          We can be reached at rzettler@givetoken.com
      </div>
      <div class ="modal-footer">
        GiveToken
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- =========================
     SCRIPTS
============================== -->
<script>
	function selectBasic() {
		selectPlan("basic");
		$('#signup-dialog').modal();
	}

	function selectStandard() {
		selectPlan("standard");
	}
	function selectPlan(plan) {
		var selectedPlan = $("#"+plan);

		// restore all plans
		$(".plan").each(function(i) {
			$(this).removeClass("plan-hover");
			$(this).addClass("plan-hover");
			$(this).removeClass("plan-selected");
		});

		// set the selected plan
		selectedPlan.removeClass("plan-hover");
		selectedPlan.addClass("plan-selected");
	}

// Immediately Invoked Function Expression (IIFE)
// Used to be referred to as a self executing function
// Avoids creating global variables and functions which can interfere with other scripts
(function() {

  var plans = {
    basic: {
      pricingChart: false,
      pricingChart2: false,
      basePrice: 0
    },
    standard: {
      pricingChart: false,
      pricingChart2: false,
      basePrice: 9.99
    },
    premium: {
      pricingChart: true,
      pricingChart2: false,
      basePrice: 49.99
    },
    enterprise: {
      pricingChart: true,
      pricingChart2: true,
      basePrice: 120
    }
  };

  var viewerLevels = {
    500: 10.99,
    2500: 20.99,
    5000: 30.99,
    10000: 40.99
  };

  var userLevels = {
    1: 100.59,
    2: 200.59,
    3: 300.59,
    4: 400.59
  };


  var selectedPlan = "basic";
  var viewerLevel = null;
  var userLevel = null;



      // Find all elements with class plan, then find all elements with class select-button within it
      // Bind to click events on those elements
      $( ".plan .select-btn" ).on( "click", function( event ) {
		  	$("#premium-dialog").modal();

/*
        // Read the plan type from the data-plan attribute on the div with class plan
        selectedPlan = $( this ).closest( ".plan" ).attr( "data-plan" );
		selectPlan(selectedPlan);

        // Get the plan information from the plans variable, based on the key that we just read from the attribute
        var planInfo = plans[ selectedPlan ];

        if ( planInfo.pricingChart ) {
          $( "#pricingChart" ).removeClass( "not" );
        } else {
          $( "#pricingChart" ).addClass( "not" );
          viewerLevel = null;
          $('.pricingLevelOn').removeClass('pricingLevelOn');
        }

        if ( planInfo.pricingChart2 ) {
          $( "#pricingChart2" ).removeClass( "not" );
        } else {
          $( "#pricingChart2" ).addClass( "not" );
          userLevel = null;
          $('.pricingLevelOn2').removeClass('pricingLevelOn2');
        }

        // Determine which pricing chart to scroll to
        var showPricingChart = "#topPricingChart";
        if ( planInfo.pricingChart ) {
          showPricingChart = "#pricingChart";
        }

        // Scroll to the pricing chart
        // https://github.com/jquery/api.jquery.com/issues/417
        $( "html,body" ).animate({
          scrollTop: $( showPricingChart ).offset().top
        }, "slow" );

        updatePrice();
*/

      });

      $( ".pricingLevel" ).on( "click", function() {
        // Update the "global" viewer level
        viewerLevel = $( this ).attr( "data-viewer" );

        // Update the color/ selected element
        var size = viewerLevel
        $('.pricingLevelOn').removeClass('pricingLevelOn');
        var tab = $('#pricing' + size.toString());
        tab.addClass('pricingLevelOn');

        // update the price
        updatePrice();
      });

      $( ".pricingLevel2" ).on( "click", function() {
        userLevel = $( this ).attr( "data-user" );

        var size2 = userLevel
        $('.pricingLevelOn2').removeClass('pricingLevelOn2');
        var tab = $('#pricingU' + size2.toString());
        tab.addClass('pricingLevelOn2');

        updatePrice();
      });

          function updatePrice() {
            var basePrice = plans[ selectedPlan ].basePrice;

            var viewerPrice = 0;
            if ( viewerLevel ) {
              viewerPrice = viewerLevels[ viewerLevel ];
            }

            var userPrice = 0;
            if ( userLevel ) {
              userPrice = userLevels[ userLevel ];
            }

            var totalPrice = basePrice + viewerPrice + userPrice;
          $( ".pricingLargeAmount" ).text( strip(totalPrice) );
          }

          //MAY NEED TO UPDATE SINCE WE ARE DEALING WITH MONEY... THIS IS NOT THE FULL WORK AROUND
          //http://stackoverflow.com/questions/1458633/elegant-workaround-for-javascript-floating-point-number-problem
          function strip(number) {
            return (parseFloat(number.toPrecision(12)));
          }

        // Set the price based on the defaults defined above
        updatePrice();


        //Handeling the Continue Button
        $( "#continue" ).on( "click", function() {
          if (selectedPlan =="enterprise"){
            //CHANGE TO
            //1st accept credit card info
            //2nd tell the user the service is not yet ready
            $( '#myModal2 .modal-header' ).text( 'Enterprise Plan' )
            $('#myModal2').modal()
          } else if ( selectedPlan  == "premium" ){
            //CHANGE TO
            //1st accept credit card info
            //2nd tell the user the service is not yet ready
            $( '#myModal2 .modal-header' ).text( 'Premium Plan' )
            $('#myModal2').modal()
          } else if ( selectedPlan  == "standard" ){
            //CHANGE TO
            //1st If click Log In have them Log In then go to Stripe Collectio OR if they hit sign up do all in one: sign up and collect credit info
            //2nd lead user to create screen with activated service
            $( '#myModal .modal-header' ).text( 'Standard Plan' )
            $('#myModal').modal()

          } else if ( selectedPlan  == "basic" ){
            //this is the free option... the user should not see the continue button... they should only click sign up
            $( '#myModal .modal-header' ).text( 'Basic Plan' )
            $('#myModal').modal()

          } else {
            alert("How did you get to this option??");
          }

        });

})();

</script>

<script src="js/bootstrap.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.localScroll.min.js"></script>
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
<script src="js/facebook_init.js"></script>
<script src="js/custom.js"></script>
<script src="js/util.js"></script>
<script src="pay_with_stripe.php"></script>
<script src="js/login.js"></script>
<script src="js/signup.js"></script>
<script src="js/account.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<!--
		<center>
			<br><br><br><br>
			<h1 id="attached-narrow">Pricing</h1>
			<h1>Please contact Robbie Zettler at</h1>
			<a href="mailto:rzettler@givetoken.com?Subject=Givetoken%20pricing" target="_top"><h1><b>rzettler@givetoken.com</b></h1></a>
		</center>
  -->
</body>
</html>
