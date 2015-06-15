<?php
	include_once 'Token.class.php';
	include_once 'config.php';
	use google\appengine\api\cloud_storage\CloudStorageTools;
	if ($google_app_engine) {
		include_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
	}

	$token = new Token($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $token->name ?></title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">
	<link rel="stylesheet" href="css/colorbox.css" />
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.colorbox-min.js"></script>
	<script src="//vjs.zencdn.net/4.11/video.js"></script>
	<script src="js/preview.js"></script>

	<!-- CUSTOM STYLESHEETS -->
	<link rel="stylesheet" href="css/styles.css">
	<script src="js/customs.js"></script>

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
	<?php /*include_once("analyticstracking.php")*/ ?>
	<!-- =========================
	     PRE LOADER       
	============================== -->
	<div class="preloader">
	  <div class="status">&nbsp;</div>
	</div>
	<?php
	echo '<div id="triggerTab"></div>';
	echo '<div class="giftbox panel" id="flip-container">';
	echo '<div class="front">';
	echo ($token->letter_text || $token->attachments)  ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL;

	$token->render();

	echo "</div>";
	echo '<div class="back">';
	echo ($token->letter_text || $token->attachments) ? '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL : NULL;

	echo '<div id="letter-text-container">';
	echo '<div id="letter-text">';
	echo '<p>'.($token->letter_text).'</p>';
	echo '<p id="letter-attachments">';
	foreach ($token->attachments as $attachment) {
		if ($google_app_engine) {
			$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$attachment->download_file_name, $use_https);
		} else {
			$image_path = $file_storage_path.$attachment->download_file_name;
		}
		echo '<a href="'.$image_path.'" target="_blank"><i class="fa fa-file fa-x2"></i> '.$attachment->file_name.'</a>';
	}
	echo '</p>';
	echo '</div>'; // letter-text
	echo "</div>"; // letter-text-container
	echo "</div>"; // back
	echo "</div>"; // flip-container
	?>
</body>
</html>