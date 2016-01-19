<?php
$message = null;
$first_name = null;
$last_name = null;
$email = null;
$user_id = null;

if (!logged_in()) {
    header('Location: '.'/');
}
define('TITLE', 'S!zzle - Profile');
require __DIR__.'/header.php';
?>

<!-- REACT -->
<script src="/js/react.min.js"></script>
<script src="/js/JSXTransformer.js"></script>

</head>

<body id="profile-page">

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div id="account-profile">
  </div>
</header>
<!-- /END HEADER -->

<!-- =========================
     ACCOUNT PROFILE
============================== -->

<script type="text/javascript" src="https://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/md5.js"></script>
<script type="text/javascript" src="/app/models/model.js?v=<?php echo VERSION;?>"></script>
<script type="text/jsx" src="/app/account/AccountStore.js?v=<?php echo VERSION;?>"></script>

<!-- React Components -->
<script type="text/jsx" src="/app/account/profile.js?v=<?php echo VERSION;?>"></script>
<script type="text/jsx" src="/app/account/info.js?v=<?php echo VERSION;?>"></script>
<script type="text/jsx" src="/app/account/user_edit.js?v=<?php echo VERSION;?>"></script>
<script type="text/jsx" src="/app/account/index.js?v=<?php echo VERSION;?>"></script>


<section class="profile" id="account-profile"></section>
<script type="text/jsx">
  React.render(<Account model={Model} />, document.getElementById('account-profile'));
</script>

<?php require __DIR__.'/footer.php';?>
<?php if (isset($_SESSION['stripe_id'])) { ?>
  <script>
  $(document).ready(function() {
    // normal load
    setTimeout(function () {
      $('#upgrade-button').hide();
    }, 500);
    // normal load
    setTimeout(function () {
      $('#upgrade-button').hide();
    }, 1000);
    // slowish load
    setTimeout(function () {
      $('#upgrade-button').hide();
    }, 5000);
    //snail load
    setTimeout(function () {
      $('#upgrade-button').hide();
    }, 30000);
  });
  </script>
<?php }?>
</body>
</html>
