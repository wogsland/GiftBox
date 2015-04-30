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
	<!--<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">-->
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<!--<script src="//vjs.zencdn.net/4.11/video.js"></script>-->
	<script src="js/preview.js"></script>
</head>
<body>
	<?php /*include_once("analyticstracking.php")*/ ?>
	<?php
	echo '<div class="giftbox panel" id="flip-container">';
	echo '<div class="front">';
	echo $token->letter_text ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL;

	$token->render();

	echo "</div>";
	echo '<div class="back">';
	echo $token->letter_text ? '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL : NULL;

	echo '<div id="letter-text">';
	echo '<p>'.nl2br($token->letter_text).'</p>';
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
	echo '</div>';
	echo "</div>";
	echo "</div>";
	?>
</body>
</html>
