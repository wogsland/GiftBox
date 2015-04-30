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
	<div id="content-wrapper">
		<div class="header-wrapper" id="create-header-wrapper">
			<header>
				<h1>
					<a id="create-home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
				</h1>
				<nav id="create-top-nav">
					<ul>
						<li>
							<a href="<?php echo $app_root ?>">Home</a>
						</li>
						<li>
							<a href="business-solutions/business-solutions.html">Business Solutions</a>
						</li>
						<li>
							<a href="about-us/about-us.html">About Us</a>
						</li>
					</ul>
				</nav>
			</header>
		</div>
		<div id="centering-wrapper">
			<a class="pure-button" href="manage_users.php">Manage Users</a>
		</div>
	</div>
</body>
</html>
