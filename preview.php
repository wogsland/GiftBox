<?php
	include_once 'util.php';
	include_once 'config.php';
	$downloads = array();
	require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
	use google\appengine\api\cloud_storage\CloudStorageTools;
	
	$sql = "SELECT * from giftbox where id = ".$_GET['id'];
	$query = execute_query($sql);
	$row = $query->fetch_object();
	$letterText = $row->letter_text;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $row->name ?></title>
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
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
			<div class="template" id="preview">
<?php
					$sql = "SELECT * FROM bento WHERE giftbox_id = ".$_GET['id'];
					$query = execute_query($sql);
					while ($row = $query->fetch_object()) {
						echo "\t\t\t\t".'<div class="preview-bento" style="position:absolute; top:'.$row->css_top.'; left:'.$row->css_left.'; width:'.$row->css_width.'; height:'.$row->css_height.'">'.PHP_EOL;
						if ($row->image_file_name) {
							echo "\t\t\t".'<img src="uploads/'.$row->image_file_name.'" width="'.$row->image_width.'" height="'.$row->image_height.'" style="position:absolute; top:'.$row->image_top.'; left:'.$row->image_left.'">'.PHP_EOL;
						}
						if ($row->download_file_name) {
							$downloads[] = $row->download_file_name;
							if (strpos($row->download_mime_type, 'video') === 0) {
								echo "\t\t\t\t\t"."<video id=\"".$row->download_file_name."\" class=\"video-js vjs-default-skin video-player\" data-setup='{\"controls\": true, \"autoplay\": false, \"preload\": \"auto\"}' width=\"".str_replace("px", null, $row->css_width)."\"  height=\"".str_replace("px", null, $row->css_height)."\" controls>".PHP_EOL;
								echo "\t\t\t\t\t\t".'<source src="uploads/'.$row->download_file_name.'" type="'.$row->download_mime_type.'" />'.PHP_EOL;
								echo "\t\t\t\t\t\t".'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>';									
								echo "\t\t\t\t\t".'</video>'.PHP_EOL;
							} else if (strpos($row->download_mime_type, 'audio') === 0) {
								echo "\t\t\t\t\t".'<audio class="audio-player" src="uploads/'.$row->download_file_name.'" width="'.$row->css_width.'" controls>';
							} else {
								echo "\t\t".'<img class="download-icon" src="images/download.jpg">';
							}
						}
						echo "\t\t\t\t</div>".PHP_EOL;
					}
?>
			</div>
<?php
				if ($letterText) {
					echo "\t\t\t".'<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL;
				}
?>
		</div>
		<div class="back">
<?php
				if ($letterText) {
					echo "\t\t\t".'<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL;
				}
?>
			<p id="letter-text"><?php echo str_replace("\n", "<br />", $letterText) ?></p>
		</div>
	</div>
	<div class="download-container">
<?php
	foreach ($downloads as $theFile) {
		echo "\t\t".'<a class="pure-button download-button" href="'
		if ($google_app_engine) {
			$object_url = $file_storgage_path.$theFile;
			$object_public_url = CloudStorageTools::getPublicUrl($object_url, false);
		} else {
			$file_storage_path.$theFile.'" target="_blank">'.$theFile.'</a>'.PHP_EOL;
		}
	}
?>
	</div>
</body>
</html>