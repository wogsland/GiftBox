<?php
include_once "config.php";

_session_start();
if (!logged_in() || !is_admin()) {
	echo 'You must be a logged in as a GiveToken admin to view this page.';
	exit;
}

$tokens = execute_query("SELECT giftbox.id, name, first_name, last_name  FROM giftbox, user where giftbox.user_id = user.id ORDER BY id")->fetch_all(MYSQLI_ASSOC);

foreach ($tokens as $token) {
	echo "<br><b>Token-{$token['id']} {$token['name']} ({$token['first_name']} {$token['last_name']})</b><br>";
	$bentos = execute_query("SELECT * FROM bento WHERE giftbox_id = {$token['id']} ORDER BY css_id")->fetch_all(MYSQLI_ASSOC);
	foreach ($bentos as $bento) {
		echo "{$bento['css_id']}: ";
		if ($bento['image_file_name']) {
			echo $bento['image_file_name'];
			if (file_exists($file_storage_path.$bento['image_file_name'])) {
				echo " (".filesize($file_storage_path.$bento['image_file_name'])." bytes)";
			} else {
				echo " (FILE NOT FOUND)";
			}
		}
		if ($bento['cropped_image_file_name']) {
			echo ", {$bento['cropped_image_file_name']}";
			if (file_exists($file_storage_path.$bento['cropped_image_file_name'])) {
				echo " (".filesize($file_storage_path.$bento['image_file_name'])." bytes)";
			} else {
				echo " (FILE NOT FOUND)";
			}
		}
		echo "<br>";

	}
}
