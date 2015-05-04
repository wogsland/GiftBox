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
	<meta charset="utf-8" />
	<!-- SITE TITLE -->
	<title>GiveToken.com - Manage Users</title>
	<!-- =========================
	     STYLESHEETS
	============================== -->
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- FONT ICONS -->
	<link rel="stylesheet" href="assets/elegant-icons/style.css">
	<link rel="stylesheet" href="assets/app-icons/styles.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />

	<!-- WEB FONTS -->
	<link href='//fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic' rel='stylesheet' type='text/css'>


	<!--<link rel="stylesheet" href="css/style.css" />-->
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!--<link rel="stylesheet" href="css/pure/pure-min.css">-->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
    <script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/account.js"></script>

	<!-- ANIMATIONS -->
	<link rel="stylesheet" href="css/animate.min.css">

	<!-- CUSTOM STYLESHEETS -->
	<link rel="stylesheet" href="css/styles.css">

	<!-- COLORS -->
	<link rel="stylesheet" href="css/colors.css">

	<!-- RESPONSIVE FIXES -->
	<link rel="stylesheet" href="css/responsive.css">



	<!--[if lt IE 9]>
				<script src="js/html5shiv.js"></script>
				<script src="js/respond.min.js"></script>
	<![endif]-->


	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="assets/gt-favicons.ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/gt-favicons.ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/gt-favicons.ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/gt-favicons.ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/gt-favicons.ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/gt-favicons.ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/gt-favicons.ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/gt-favicons.ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/gt-favicons.ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="assets/gt-favicons.ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/gt-favicons.ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/gt-favicons.ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/gt-favicons.ico/favicon-16x16.png">
	<link rel="manifest" href="assets/gt-favicons.ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- endFavicon -->
</head>
<body>
	<div>
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
								<?php
								if (logged_in()) {
									echo '<li><a href="account.php" class="external">My Account</a></li>';
								} else {
									echo '<li><a href="#">Login</a></li>';
								}
								?>
					</ul>
				</nav>
			</header>
		</div>
					</div> <!-- /END CONTAINER -->
				</div> <!-- /END STICKY NAVIGATION -->
		
			</div>
			<!-- /END COLOR OVERLAY -->
			</header>

		<div class="container">

			<div class="container">
				<form class="jumbotron" id="manage-jumbo" method="get" action="manage_users.php">
					<fieldset>
						<legend id="searchHeader">Search for a user</legend>
						<input name="first-name" type="text" placeholder="First Name" value="<?php if (isset($_GET['first-name'])) {echo $_GET['first-name'];} ?>">
						<input name="last-name" type="text" placeholder="Last Name" value="<?php if (isset($_GET['last-name'])) {echo $_GET['last-name'];} ?>">
						<input name="email" type="email" placeholder="Email" value="<?php if (isset($_GET['email'])) {echo $_GET['email'];} ?>">
						<label for="admin">
							<input name="admin" id="admin" type="checkbox" <?php if (isset($_GET['admin'])) echo "checked" ?>> Administrator
						</label>
						<input type="submit" class="pure-button pure-button-primary" value="Search">
					</fieldset>
				</form>
			</div>
			<div class="container">
				<table  class="table-hover" id="manage-table">
					<thead><tr><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Administrator</th><th></th><th></th></tr></thead>
					<tbody>
					<?php
						$sql = "SELECT * from user WHERE 1 = 1";
						if (isset($_GET['last-name']) && strlen($_GET['last-name']) > 0) {
							$sql .= " AND upper(last_name) = upper('".$_GET['last-name']."')";
						}
						if (isset($_GET['first-name']) && strlen($_GET['first-name']) > 0) {
							$sql .= " AND upper(first_name) = upper('".$_GET['first-name']."')";
						}
						if (isset($_GET['email']) && strlen($_GET['email']) > 0) {
							$sql .= " AND upper(email_address) = upper('".$_GET['email']."')";
						}
						if (isset($_GET['admin'])) {
							$sql .= " AND admin = 'Y'";
						}
						$sql .= " ORDER BY last_name, first_name";
						$results = execute_query($sql);
						while ($user = $results->fetch_object()) {
							print '
							<tr>
								<td id="first-name-'.$user->id.'">'.$user->first_name.'</td>
								<td id="last-name-'.$user->id.'">'.$user->last_name.'</td>
								<td id="email-'.$user->id.'">'.$user->email_address.'</td>
								<td id="admin-'.$user->id.'">'.$user->admin.'</td>
								<td><a class="pure-button open-popup-link" href="javascript:void(0)" onclick="editUser('.$user->id.')"><i class="fa fa-edit fa-lg"></i> Edit</a></td>
								<td><a class="pure-button" href="event_history.php?user_id='.$user->id.'" target="_blank""><i class="fa fa-history fa-lg"></i> History</a></td>
</tr>';
						}
						?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<form class="white-popup mfp-hide" id="edit-user-form" name="edit-user-form">
		<fieldset>
			<legend>Edit a user</legend>
			<p id="edit-user-message"></p>
			<input id="user-id" name="user_id" type="hidden">
			<input id="first-name-edit" name="first_name" type="text" placeholder="First Name">
			<input id="last-name-edit" name="last_name" type="text" placeholder="Last Name">
			<input id="email-edit" name="email" type="email" placeholder="Email">
			<label for="admin-edit">
				<input id="admin-edit" name="admin" type="checkbox" value="Y"> Administrator
			</label>
			<a class="pure-button pure-button-primary" href="javascript:void(0)" onclick="saveUser()">Save</a>
		</fieldset>
	</form>
	
</body>
</html>
