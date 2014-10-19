<?php
	include_once 'config.php';
	include_once 'util.php';
	session_start();
	if (!logged_in() || !is_admin()) {
		header('Location: '.$app_root);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Manage Users</title>
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/pure/pure-min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
    <script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/account.js"></script>
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
							<a href="<?php echo $app_root ?>admin.php">Admin</a>
						</li>
					</ul>
				</nav>
			</header>
		</div>
		
		<div id="centering-wrapper">

			<div id="user-search-form-wrapper">
				<form class="pure-form" method="get" action="manage_users.php">
					<fieldset>
						<legend>Search for a user</legend>
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
			<div id="user-table-wrapper">
				<table  class="pure-table pure-table-bordered">
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
	
	<form class="pure-form pure-form-aligned white-popup mfp-hide" id="edit-user-form" name="edit-user-form">
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
