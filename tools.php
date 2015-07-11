<?php
include_once "util.php";
include_once "config.php";

$tokens = execute_query("SELECT giftbox.id, name, first_name, last_name  FROM giftbox, user where giftbox.user_id = user.id ORDER BY id")->fetch_all(MYSQLI_ASSOC);

foreach ($tokens as $token) {
	echo "<br><b>{$token['name']} ({$token['first_name']} {$token['last_name']})</b><br>";
	$bentos = execute_query("SELECT * FROM bento WHERE giftbox_id = {$token['id']} ORDER BY css_id")->fetch_all(MYSQLI_ASSOC);
	foreach ($bentos as $bento) {
		echo "{$bento['css_id']}: ";
		if ($bento['image_file_name']) {
			echo $bento['image_file_name'];
			if ($google_app_engine) {
				$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento['image_file_name'], $use_https);
			} else {
				$image_path = $file_storage_path.$bento['image_file_name'];
			}
			if (file_exists($image_path)) {
				echo " (".filesize($image_path)." bytes)";
			} else {
				echo " (FILE NOT FOUND)";
			}
		}
		if ($bento['cropped_image_file_name']) {
			echo ", {$bento['cropped_image_file_name']}";
			if ($google_app_engine) {
				$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento['cropped_image_file_name'], $use_https);
			} else {
				$image_path = $file_storage_path.$bento['cropped_image_file_name'];
			}
			if (file_exists($image_path)) {
				echo " (".filesize($image_path)." bytes)";
			} else {
				echo " (FILE NOT FOUND)";
			}
		}
		echo "<br>";
		
	}
}