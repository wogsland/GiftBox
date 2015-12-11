<?php
use \GiveToken\User;

require_once __DIR__.'/config.php';

if (!logged_in()) {
    header('Location: '.$app_url.'pricing');
}

define('TITLE', 'GiveToken.com - Give a Token of Appreciation');
require __DIR__.'/header.php';

?>
<style>
#upgrade-button {
  margin-top:200px;
  margin-bottom:300px;
}
</style>
</head>

<body id="upgrade-page">

  <!-- =========================
       HEADER
  ============================== -->
  <header class="header" data-stellar-background-ratio="0.5" id="account-profile">
    <!-- SOLID COLOR BG -->
    <div class="">
        <?php require __DIR__.'/navbar.php';?>
    </div>
    <!-- /END COLOR OVERLAY -->
  </header>
  <!-- /END HEADER -->

  <button type="button"
    id="upgrade-button"
    class="btn btn-success"
    onclick="payWithStripe('<?php echo $_SESSION['email'];?>','UPGRADE')">
    Upgrade <i class="fa fa-chevron-right"></i>
  </button>

  <?php require __DIR__.'/footer.php';?>
  <!-- =========================
       PAGE SPECIFIC SCRIPTS
  ============================== -->
  <script src="js/pricing.min.js?v=<?php echo VERSION;?>"></script>
  <script>
    $('#upgrade-button').click();
  </script>

</body>
</html>
