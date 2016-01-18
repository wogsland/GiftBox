<?php
use \GiveToken\User;

define('TITLE', 'GiveToken.com - Give a Token of Appreciation');
require __DIR__.'/header.php';
?>
</head>

<body id="pricing-page">

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
<center style="margin-top:100px;margin-bottom:500px;">
  <h3>For pricing information please contact Robbie Zettler at</h3>
  <a href="mailto:rzettler@gosizzle.io?Subject=Givetoken%20pricing" target="_top"><h3><b>rzettler@gosizzle.io</b></h3></a>
</center>

<!-- These modals will be deleted when Stripe is used -->

<div class="modal fade"  id="premium-dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class ="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="gridSystemModalLabel"><b>Pricing Information</b></h3>
      </div>
      <div class ="modal-body">
        <center>
          <h3>Please contact Robbie Zettler at</h3>
          <a href="mailto:rzettler@gosizzle.io?Subject=Sizzle%20pricing" target="_top"><h3><b>rzettler@gosizzle.io</b></h3></a>
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
          We can be reached at rzettler@gosizzle.io
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
<script src="js/pricing.min.js?v=<?php echo VERSION;?>"></script>

</body>
</html>
