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
	<title>Giftbox - History</title>
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
	<div id="centering-wrapper">
		<table id="event-table" class="pure-table pure-table-bordered">
			<thead><tr><th>First Name</th><th>Last Name</th><th>Event</th><th>Event Time</th><th>Event Info</th></tr></thead>
			<tbody>
			<?php
				$sql = "SELECT * from log ";
				if (isset($_GET['user_id'])) {
					$sql .= "WHERE user_id = ".$_GET['user_id'];
				}
				$sql .= " ORDER BY event_time desc";
				$results = execute_query($sql);
				while ($event = $results->fetch_object()) {
					print '
					<tr>
						<td>'.$event->first_name.'</td>
						<td>'.$event->last_name.'</td>
						<td>'.$event->event_type_name.'</td>
						<td>'.$event->event_time.'</td>
						<td>'.$event->event_info.'</td>
					</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</body>
</html>

		