<?php
define('TITLE', 'S!zzle - Careers');
require __DIR__.'/header.php';
?>
<style>
  #jobs-iframe {
    margin-top: 30px;
  }
</style>
</head>

<body id="careers-page">

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5">

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
      <div class="col-lg-offset-2 col-lg-8">
        <h2>Careers</h2>
        <p class="text-justify">
          Interested in working with us here at S!zzle? Checkout out our available positions
          below:
        </p>
        <iframe
          id="jobs-iframe"
          src="<?=APP_URL.'job_listing?id=1'?>"
          height="400"
          width="100%"
          frameborder="0">
        </iframe>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->

</body>
</html>
