<?php
include_once 'config.php';
_session_start();
if (!logged_in()) {
    header('Location: '.$app_url);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Select Type</title>
	<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
	<link href='//fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en' rel='stylesheet' type='text/css'>
  	<style>
		html, body {
			width: 100%;
			height: 100%;
		}
		#button-wrapper {
			padding-top: 50px;
		}
		.button-container {
			width: 100%;
			padding: 5px;
		}
		.button-link {
			width: 895px;
			margin: auto;
			display: block;
			box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.12), 0px 2px 2px 0px rgba(0,0,0,0.24);
			padding: 25px 0px 25px 60px;
			text-decoration: none;
			vertical-align: top;
			font-size: 0;
		}
		.personal {
			color: #1E88E5;
		}
		.recruiting {
			color: #43A047;
		}
		.button-link:hover {
			text-decoration: none;
		}
		.left-container {
			height: 260px;
			width: 260px;
			display: inline-block;
			position: relative;
			border: solid 0px black;
			box-sizing: border-box;
		}
		.right-container {
			height: 260px;
			width: 620px;
			display: inline-block;
			position: relative;
			vertical-align: top;
			border: solid 0px black;
			box-sizing: border-box;
			padding: 40px 0px 40px 40px;
		}
		.button-title {
			font-family: "Roboto", sans-serif;
			font-size: 48px;
			display: block;
		}
		.button-text {
			color: black;
			padding: 0px 0px;
			font-family: "Roboto", sans-serif;
			font-size: 18px;
		}
		.button-icon {
			font-size: 120px;
			color: white;
			position: absolute;
			top: 70px;
			left: 70px;
		}
		.circle {
			height: 260px;
			width: 260px;
		}

	</style>
</head>
<body>
	<div id="button-wrapper">
		<div class="button-container">
			<a href="create.php" class="personal button-link">
				<div class="left-container">
					<svg class="circle" xmlns="http://www.w3.org/2000/svg" version="1.1">
						<circle cx="130" cy="130" r="130 "fill="#1E88E5" />
					</svg>
					<i class="material-icons button-icon">face</i>
				</div>
				<div class="right-container">
					<span class="button-title">Personal</span>
					<p class="button-text">A Personal Token is a fun and exciting way to send out your next email.  It combines multiple forms of digital mdedia: pictures, video, music, links, and much more into an interactive collage that can be sent in an email.</p>
				</div>
			</a>
		</div>
		<?php if (is_admin()) { ?>
			<div class="button-container">
				<a href="create_recruiting.php" class="recruiting button-link">
					<div class="left-container">
						<svg class="circle" xmlns="http://www.w3.org/2000/svg" version="1.1">
							<circle cx="130" cy="130" r="130 "fill="#43A047" />
						</svg>
						<i class="material-icons button-icon">work</i>
					</div>
					<div class="right-container">
						<span class="button-title">Recruiting</span>
						<p class="button-text">A Recruiting Token is an engaging way to reach out to potential candidates.  Recruiting Tokens turn plain text job descriptions into interactive experiences.  Recruiting Tokens have a proven track record of drawing larger audiances -- meaning you not only have more people clicking on your job description, but also responding to it.</p>
					</div>
				</a>
			</div>
		<?php }?>
	</div>
</body>
</html>
