<?php
use \Sizzle\UserGroup;

if (!logged_in() || !is_admin()) {
    header('Location: '.'/');
}
define('TITLE', 'S!zzle - Manage Groups');
require __DIR__.'/header.php';
?>

<link rel="stylesheet" href="css/users_groups.min.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/manage_groups.js?v=<?php echo VERSION;?>"></script>
</head>
<body>
	<header class="header" data-stellar-background-ratio="0.5" id="account-profile">
		<div class="">
        <?php require __DIR__.'/navbar.php';?>
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
    <?php require __DIR__.'/footer.php';?>
</body>
</html>
