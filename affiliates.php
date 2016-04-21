<?php
use \Sizzle\Bacon\Database\User;

define('TITLE', 'S!zzle - Affiliate Program');
require __DIR__.'/header.php';
?>
<style>
#program-section {
  margin-top: 150px;
  margin-bottom: 300px
}
.white-line {
  margin-bottom: 20px;
}
</style>
</head>

<body id="affiliate-page">

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

<section id="program-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-3 col-lg-6">
        <h2>S!zzle Affiliate Program</h2>
        <div class="white-line" ></div>
        <p class="text-justify">
          S!zzle is a Nashville, TN based company dedicated to helping
          recruiters. Do you know recruiters that might benefit from
          our service? Introduce us to them using
          <a href="mailto:affiliate@gosizzle.io">affiliate@gosizzle.io</a>
          and will cut you in on 50% for their first 6 months of service.
          That's up to $825 per lead! Just email us to get started.
        </p>
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
