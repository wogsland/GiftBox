<?php
	include_once 'config.php';
	include_once 'util.php';
	_session_start();
	if (!logged_in() || !is_admin()) {
		header('Location: '.$app_root);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GiveToken - Admin</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css" />
</head>
<body>
	<!-- STICKY NAVIGATION -->
	<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
		<div class="container">
			<div class="navbar-header">

				<!-- LOGO ON STICKY NAV BAR -->
				<a class="navbar-brand" href="<?php echo $app_root ?>"><img src="assets/img/logo-light.png" alt=""></a>

			</div>

			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="kane-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<li><a href="<?php echo $app_root ?>">Home</a></li>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->
	<div style="margin-top: 100px">
		<a class="btn btn-lg btn-default" role="button" href="manage_users.php">Manage Users</a>
	<div>
</body>
</html>