<?php
require_once __DIR__.'/config.php';
if (!logged_in()) {
    header('Location: '.$app_url);
}

define('TITLE', 'GiveToken.com - Select Type');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/css/token-type.css">
</head>
<body>
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
	<div id="select-button-wrapper">
		<div class="select-button-container">
			<a href="/create" class="select-personal select-button-link">
				<div class="select-left-container">
					<svg class="circle" xmlns="http://www.w3.org/2000/svg" version="1.1">
						<circle cx="130" cy="130" r="130 "fill="#1E88E5" />
					</svg>
					<i class="material-icons select-button-icon">face</i>
				</div>
				<div class="select-right-container">
					<span class="select-button-title">Personal</span>
					<p class="select-button-text">A Personal Token is a fun and exciting way to send out your next email.  It combines multiple forms of digital mdedia: pictures, video, music, links, and much more into an interactive collage that can be sent in an email.</p>
				</div>
			</a>
		</div>
    <?php if (is_admin()) { ?>
			<div class="select-button-container">
				<a href="create_recruiting" class="select-recruiting select-button-link">
					<div class="select-left-container">
						<svg class="circle" xmlns="http://www.w3.org/2000/svg" version="1.1">
							<circle cx="130" cy="130" r="130 "fill="#43A047" />
						</svg>
						<i class="material-icons select-button-icon">work</i>
					</div>
					<div class="select-right-container">
						<span class="select-button-title">Recruiting</span>
						<p class="select-button-text">A Recruiting Token is an engaging way to reach out to potential candidates.  Recruiting Tokens turn plain text job descriptions into interactive experiences.  Recruiting Tokens have a proven track record of drawing larger audiances -- meaning you not only have more people clicking on your job description, but also responding to it.</p>
					</div>
				</a>
			</div>
    <?php }?>
	</div>
    <?php require __DIR__.'/footer.php';?>
</body>
</html>
