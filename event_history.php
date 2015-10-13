<?php
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
	<!-- SITE TITLE -->
	<title>GiveToken.com - History</title>
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
