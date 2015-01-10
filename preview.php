<?php
	include_once 'Token.class.php';

	$token = new Token($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $token->name ?></title>
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="//vjs.zencdn.net/4.11/video.js"></script>
	<script src="js/preview.js"></script>
</head>
<body>
	<?php 
	echo '<div class="giftbox panel" id="flip-container">';
	echo '<div class="front">';
	echo $token->letter_text ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL;
	
	$token->render();

	echo "</div>";
	echo '<div class="back">';
	echo $token->letter_text ? '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL : NULL;
	echo '<p id="letter-text">'.str_replace('n', '<br />', $token->letter_text).'</p>';
	echo "</div>";
	echo "</div>";
	?>
</body>
</html>