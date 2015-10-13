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
	<title>GiveToken.com - Manage Groups</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/users_groups.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="js/manage_groups.js"></script>
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

	<table>
		<tr>
			<th>Group Name</th>
			<th>Users</th>
			<th>Max Users</th>
			<th align="right"><button type="button" class="btn btn-success" onclick="addGroup()"><span class="glyphicon glyphicon-plus"></span> Add A Group</button></th>
		</tr>
		<?php
			$groups = UserGroup::all_user_groups();
			$disabled = "";
			foreach ($groups as $group) {
				echo '<tr id="row-'.$group['id'].'">';
				echo '<td id="group-name-'.$group['id'].'">'.$group['name'].'</td>';
				echo '<td id="group-users-'.$group['id'].'" class="centered">'.$group['user_count'].'</td>';
				echo '<td id="group-max-users-'.$group['id'].'" class="centered">'.$group['max_users'].'</td>';
				echo '<td>';
				echo '<button class="btn btn-primary" onclick="editGroup('.$group['id'].')"><span class="glyphicon glyphicon-pencil"></span> Edit</button>';
				if ($group['user_count'] > 0) {
					$disabled = "disabled='disabled'";
				} else {
					$disabled = "";
				}
				echo '<button class="btn btn-danger spaced" '.$disabled.' onclick="deleteGroup('.$group['id'].')"><span class="glyphicon glyphicon-remove"></span> Delete</button>';
				echo '</td>';
				echo '</tr>';
			}
			?>
	</table>

	<div class="modal fade" id="group-dialog" tabindex="-1" role="dialog" aria-labelledby="modal-title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal-title">Add Group</h4>
				</div>
				<div class="modal-body">
					<div class="alert" id="group-alert" role="alert"></div>
					<form id="group-form">
						<input type="hidden" id="action" name="action" value="">
						<input type="hidden" id="group-id" name="group_id" value="">
						<div class="form-group">
							<label for=group-name"">Group Name</label>
							<input type="text" class="form-control" id="group-name" name="group_name" size="50" placeholder="Group Name">
						</div>
						<div class="form-group">
							<label for=group-name"">Max Users</label>
							<input type="text" class="form-control" id="group-max-users" name="max_users" size="10" placeholder="Max Users">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="action-button" onclick="saveGroup()">Save</button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
