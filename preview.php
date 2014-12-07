<?php
	use google\appengine\api\cloud_storage\CloudStorageTools;
	include_once 'config.php';
	include_once 'Token.class.php';
	
	if ($google_app_engine) {
		include_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
	}
	$download_file_names = array();
	$download_paths = array();
	$token = new Token($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $token->name ?></title>
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="css/pure/pure-min.css">
	<link rel="stylesheet" href="//vjs.zencdn.net/4.7/video-js.css">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="//vjs.zencdn.net/4.7/video.js"></script>
</head>
<body>
	<script>
		$(document).ready(function(){
			
			$('.flip-over').click(function(e){
				$('.giftbox').addClass('flip');
				e.preventDefault();
			});
			$('.flip-back').click(function(e){
				$('.giftbox').removeClass('flip');
				e.preventDefault();
			});
			
		});
	</script>
	
	<div class="giftbox panel" id="flip-container">
		<div class="front">
			<?php echo $token->letter_text ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL; ?>
			<div class="template" id="preview">
				<?php include "./templates/$token->css_id.php"; ?>
			</div>
		</div>
		<div class="back">
			<?php
			if ($token->letter_text) {
				echo '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL;
			}
			?>
			<p id="letter-text"><?php echo str_replace("\n", "<br />", $token->letter_text) ?></p>
		</div>
	</div>
</body>
</html>