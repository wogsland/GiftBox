<?php
use \GiveToken\User;

require_once 'config.php';
_session_start();

define('TITLE', 'GiveToken.com - Give a Token of Appreciation');
require __DIR__.'/header.php';

/*
<!-- JQUERY - why are these alternate versions here?-->
<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
*/
?>
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
    <?php require __DIR__.'/navbar.php';?>
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

<?php require __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->
<script src="js/pricing.js"></script>

</body>
</html>
