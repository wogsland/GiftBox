<?php
define('TITLE', 'S!zzle - Attribution');
require __DIR__.'/header.php';
?>
<style>
#attribution-content {
  margin-top: 90px;
  margin-bottom: 400px;
}
</style>
</head>
<body id="attribution">

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="image-attribution">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->
    <?php require __DIR__.'/navbar.php';?>
</div>
<!-- /END COLOR OVERLAY -->
</header>
  <div>
    <summary id="attribution-content">
      <h1 id="attribution-header">
            Attribution
      </h1>
      <p>
        Images for the cities in tokens are taken from the English language
        version of Wikipedia (2016).
      </p>
    </summary>
  </div>

    <?php require __DIR__.'/footer.php';?>
</body>
</html>
