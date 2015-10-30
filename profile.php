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
<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->

	<!-- STICKY NAVIGATION -->
	<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
		<div class="container">
			<div class="navbar-header">

				<!-- LOGO ON STICKY NAV BAR -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#kane-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>

				<a class="navbar-brand" href="index.php"><img src="assets/img/logo-light.png" alt=""></a>

			</div>

			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="kane-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<li><a href="index.php" class="external">Home</a></li>
					<li><a href="profile.php" class="external">My Account</a></li>
					<li><a href="#">Login</a></li>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->

</div>
<!-- /END COLOR OVERLAY -->
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
