<?php
	include_once 'util.php';
	include_once 'config.php';
	$downloads = array();
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
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
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
							echo "\t\t\t".'<img src="uploads/'.$row->image_file_name.'" height="'.$row->image_height.'" style="position:absolute; top:'.$row->image_top.'; left:'.$row->image_left.'">'.PHP_EOL;
						}
						if ($row->download_file_name) {
							$downloads[] = $row->download_file_name;
							echo "\t\t".'<img class="download-icon" src="images/download.jpg">';
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
		echo "\t\t".'<a class="pure-button download-button" href="uploads/'.$theFile.'" target="_blank">'.$theFile.'</a>'.PHP_EOL;
	}
?>
	</div>
</body>
</html>