<?php
use \GiveToken\User;

include_once 'config.php';
_session_start();

define('TITLE', 'GiveToken.com - About');
include __DIR__.'/header.php';
?>
<style>
.employee {
  margin-right: 20px;
  margin-left: 20px;
}
</style>
</head>

<body id="about-page">
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
  <?php include __DIR__.'/navbar.php';?>
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<section style="margin-top: 150px; margin-bottom: 200px">
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-2 col-lg-8">
        <h2>About Us</h2>
        <p class="text-justify">
          GiveToken is a Nashville, TN based company dedicated to helping
          recruiters maximize their outreach engagement with potential recruits
          to widen the funnel and shorten the time to hire.
        </p>
        <h2>Team</h2>
        <p class="text-center">
          <a href="https://twitter.com/GP_Mazzone" target=tweet class="employee">
            <img src="/images/team/GP_Mazzone.png" width="150" />
          </a>
          <a href="https://twitter.com/rob_zet" target=tweet class="employee">
            <img src="/images/team/rob_zet.png" width="150" />
          </a>
          <a href="https://twitter.com/wogsland" target=tweet class="employee">
            <img src="/images/team/wogsland.jpg" width="150" />
          </a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->
<script src="js/pricing.js"></script>

</body>
</html>