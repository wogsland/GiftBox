<?php
use \Sizzle\User;

if (!logged_in() || !isset($_SESSION['email'])) {
    header('Location: '.APP_URL.'pricing');
}

$email = $_SESSION['email'] ?? '';

define('TITLE', 'S!zzle - Give a Token of Appreciation');
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
    onclick="payWithStripe('<?php echo $email;?>','UPGRADE')">
    Upgrade <i class="fa fa-chevron-right"></i>
  </button>

    <?php require __DIR__.'/footer.php';?>
  <!-- =========================
       PAGE SPECIFIC SCRIPTS
  ============================== -->
  <script>
    $('#upgrade-button').click();
  </script>

</body>
</html>
