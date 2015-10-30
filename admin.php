<?php
include_once 'config.php';
_session_start();
if (!logged_in() || !is_admin()) {
	header('Location: '.$app_root);
}

define('TITLE', 'GiveToken.com - Admin');
include __DIR__.'/header.php';
?>
</head>
<body>
	<div id="content-wrapper">
		<h1>
			<a id="create-home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">GiveToken</a>
		</h1>
		<nav id="create-top-nav">
			<ul>
				<li>
					<a href="<?php echo $app_root ?>">Home</a>
				</li>
				<li>
					<a href="manage_users.php">Manage Users</a>
				</li>
				<li>
					<a href="manage_groups.php">Manage Groups</a>
				</li>
			</ul>
		</nav>
	</div>
</body>
</html>
