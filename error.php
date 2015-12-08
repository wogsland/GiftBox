<?php
use \GiveToken\User;

require_once 'config.php';

define('TITLE', 'GiveToken.com - Error');
require __DIR__.'/header.php';

?>
</head>

<body id="error-page">

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

<section style="margin-top: 150px; margin-bottom: 200px">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <i class="fa fa-bicycle"></i>
        <p>
          404 Error - This isn't the page you're looking for.<br />
        </p>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->
<script src="js/pricing.js"></script>

</body>
</html>
