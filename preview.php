<?php
	include_once 'util.php';
	include_once 'config.php';
	if (!logged_in()) {
            header('Location: /giftbox');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Preview</title>
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/preview.css" />
</head>
<body>
    <div class="template" id="preview">
<?php
	$sql = "SELECT * FROM bento WHERE giftbox_id = ".$_GET['id'];
	$query = execute_query($sql);
	while ($row = $query->fetch_object()) {
		echo "\t".'<div class="preview-bento" style="top:'.$row->css_top.'; left:'.$row->css_left.'; width:'.$row->css_width.'; height:'.$row->css_height.'">'.PHP_EOL;
		echo "\t</div>".PHP_EOL;
	}
?>
    </div>
</body>
</html>