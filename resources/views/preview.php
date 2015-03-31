<?php
	include_once 'Token.class.php';

	$token = new Token($id);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $token->name ?></title>
	<link rel="stylesheet" href="<?php echo asset('css/preview.css')?>" />
	<link rel="stylesheet" href="<?php echo asset('css/create_and_preview.css')?>" />
	<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">
	<script src="<?php echo asset('js/jquery-1.10.2.min.js')?>" type="text/javascript"></script>
	<script src="//vjs.zencdn.net/4.11/video.js"></script>
	<script src="<?php echo asset('js/preview.js')?>"></script>
</head>
<body>
	<?php include_once("analyticstracking.php") ?>
	<?php 
	echo '<div class="giftbox panel" id="flip-container">';
	echo '<div class="front">';
	echo $token->letter_text ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL;
	
	$token->render();

	echo "</div>";
	echo '<div class="back">';
	echo $token->letter_text ? '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL : NULL;
	echo '<p id="letter-text">'.nl2br($token->letter_text).'</p>';
	echo "</div>";
	echo "</div>";
	?>
</body>
</html>