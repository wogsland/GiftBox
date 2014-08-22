<?php
$file_name = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
if ($file_name) {
	$image_data = file_get_contents('php://input');
	if (strpos($image_data, "base64")) {
		if (strpos($image_data, "/bmp")) {
			$image_data = base64_decode(str_replace('data:image/bmp;base64,', '', $image_data));
		} else if (strpos($image_data, "/jpg")) {
			$image_data = base64_decode(str_replace('data:image/jpg;base64,', '', $image_data));
		} else if (strpos($image_data, "/png")) {
			$image_data = base64_decode(str_replace('data:image/png;base64,', '', $image_data));
		}
	}
	file_put_contents('uploads/' . $file_name, $image_data);
}	
?>