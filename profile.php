<?php
include_once 'config.php';
_session_start();

$message = null;
$first_name = null;
$last_name = null;
$email = null;
$user_id = null;

if (logged_in()) {
    //header('Location: '.$app_root.'my_account.php');
}
define('TITLE', 'GiveToken.com - Profile');
include __DIR__.'/header.php';
?>

<!-- REACT -->
<script src="/js/react.js"></script>
<script src="/js/JSXTransformer.js"></script>

</head>

<body id="profile-page">
<!-- =========================
     PRE LOADER
============================== -->

<div class="preloader" >
  <div class="status">&nbsp;</div>
</div>



<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5">
  <div>
    <?php include __DIR__.'/navbar.php';?>
  </div>
  <div id="account-profile">
  </div>
</header>
<!-- /END HEADER -->

<!-- =========================
     ACCOUNT PROFILE
============================== -->

<script type="text/javascript" src="https://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/md5.js"></script>
<script type="text/javascript" src="/app/models/model.js"></script>
<script type="text/jsx" src="/app/account/AccountStore.js"></script>

<!-- React Components -->
<script type="text/jsx" src="/app/account/profile.js"></script>
<script type="text/jsx" src="/app/account/activities.js"></script>
<script type="text/jsx" src="/app/account/tokens.js"></script>
<script type="text/jsx" src="/app/account/token_analytics.js"></script>
<script type="text/jsx" src="/app/account/viewers.js"></script>
<script type="text/jsx" src="/app/account/viewer_edit.js"></script>
<script type="text/jsx" src="/app/account/info.js"></script>
<script type="text/jsx" src="/app/account/users.js"></script>
<script type="text/jsx" src="/app/account/user_edit.js"></script>
<script type="text/jsx" src="/app/account/user_remove.js"></script>
<script type="text/jsx" src="/app/account/index.js"></script>


<section class="profile" id="account-profile"></section>
<script type="text/jsx">
  React.render(<Account model={Model} />, document.getElementById('account-profile'));
</script>

<?php include __DIR__.'/footer.php';?>
</body>
</html>
