<?php
use \GiveToken\UserGroup;

include_once 'config.php';

_session_start();
if (!logged_in() || !is_admin()) {
    header('Location: '.$app_root);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>GiveToken.com - Manage Users</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/users_groups.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="js/manage_users.js"></script>
</head>
<body>
	<header class="header" data-stellar-background-ratio="0.5" id="account-profile">
		<div class="">
			<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
				<div class="container">
					<div class="navbar-header">
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
							<li><a href="index.php" class="external">HOME</a></li>
							<li><a href="admin.php" class="external">ADMIN</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Search For A User</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline" method="get" action="manage_users.php">
					<div class="form-group">
						<input class="form-control" name="first-name-search" type="text" placeholder="First Name" value="<?php if (isset($_GET['first-name-search'])) {echo $_GET['first-name-search'];} ?>">
						<input class="form-control" name="last-name-search" type="text" placeholder="Last Name" value="<?php if (isset($_GET['last-name-search'])) {echo $_GET['last-name-search'];} ?>">
						<input class="form-control" name="email-search" type="email" placeholder="Email" value="<?php if (isset($_GET['email-search'])) {echo $_GET['email-search'];} ?>">
						<label for="admin">
							<input name="admin-search" id="admin-search" type="checkbox" <?php if (isset($_GET['admin-search'])) echo "checked" ?>> Administrator
						</label>
						<input type="submit" class="btn btn-primary" value="Search">
					</div>
				</form>
			</div>
		</div>
		<div class="container">
			<table>
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email Address</th>
						<th>Level</th>
						<th>Group</th>
						<th>Group<br>Administrator</th>
						<th>Givetoken<br>Administrator</th>
						<th><button type="button" class="btn btn-success" onclick="addUser()"><span class="glyphicon glyphicon-plus"></span> Add A User</button></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sql = "SELECT user.*, user_group.name as group_name FROM user LEFT JOIN user_group ON user.user_group = user_group.id  WHERE 1 = 1";
					if (isset($_GET['last-name-search']) && strlen($_GET['last-name-search']) > 0) {
						$sql .= " AND upper(last_name) = upper('".$_GET['last-name-search']."')";
					}
					if (isset($_GET['first-name-search']) && strlen($_GET['first-name-search']) > 0) {
						$sql .= " AND upper(first_name) = upper('".$_GET['first-name-search']."')";
					}
					if (isset($_GET['email-search']) && strlen($_GET['email-search']) > 0) {
						$sql .= " AND upper(email_address) = upper('".$_GET['email-search']."')";
					}
					if (isset($_GET['admin-search'])) {
						$sql .= " AND admin = 'Y'";
					}
					$sql .= " ORDER BY last_name, first_name";
					$results = execute_query($sql);
					while ($user = $results->fetch_object()) {
						print '
						<tr id="row-'.$user->id.'">
							<td id="first-name-'.$user->id.'">'.$user->first_name.'</td>
							<td id="last-name-'.$user->id.'">'.$user->last_name.'</td>
							<td id="email-'.$user->id.'">'.$user->email_address.'</td>
							<td id="level-'.$user->id.'">'.($user->level == 1 ? "Basic" : "Standard").'</td>
							<td id="group-'.$user->id.'">'.$user->group_name.'</td>
							<td id="group-admin-'.$user->id.'" class="centered">'.$user->group_admin.'</td>
							<td id="admin-'.$user->id.'" class="centered">'.$user->admin.'</td>
							<td class="centered"><button class="btn btn-primary" onclick="editUser('.$user->id.')"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
							<td class="centered"><a class="btn btn-default" href="event_history.php?user_id='.$user->id.'" role="button" target="_blank""><span class="glyphicon glyphicon-user"></span> History</a></td>
						</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="user-dialog" tabindex="-1" role="dialog" aria-labelledby="modal-title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal-title">Add User</h4>
				</div>
				<div class="modal-body">
					<div class="alert" id="dialog-alert" role="alert"></div>
					<form id="user-form">
						<input type="hidden" id="action" name="action" value="">
						<input type="hidden" id="user-id" name="user_id" value="">
						<div class="form-group">
							<label for="first-name">First Name</label>
							<input type="text" class="form-control" id="first-name" name="first_name" size="50" placeholder="First Name">
						</div>
						<div class="form-group">
							<label for="last-name">Last Name</label>
							<input type="text" class="form-control" id="last-name" name="last_name" size="50" placeholder="Last Name">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" id="email" name="email" size="50" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="text" class="form-control" id="password" name="password" size="50" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="level">Level</label>
							<select class="form-control" id="level" name="level">
								<option value="1">Basic</option>>
								<option value="2">Standard</option>
							</select>
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label for="group">Group</label>
								<select class="form-control" id="group" name="group">
									<option value=""></option>
									<?php
										$groups = UserGroup::all_user_groups();
										foreach ($groups as $group) {
											echo '<option value="'.$group['id'].'">'.$group['name'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="checkbox">
							  <label>
								<input id="group-admin" name="group_admin" type="checkbox" value="Y">
								Group Administrator
							  </label>
							</div>
						</div>
						<div class="checkbox">
						  <label>
							<input id="admin" name="admin" type="checkbox" value="Y">
							Givetoken Administrator
						  </label>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="action-button" onclick="saveUser()">Save</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
