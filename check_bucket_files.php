<?php
include_once "config.php";

_session_start();
if (!logged_in() || !is_admin()) {
	echo 'You must be a logged in as a GiveToken admin to view this page.';
	exit;
}

$dir = opendir($file_storage_path);
$count = 0;
$delete = false;
if (isset($_GET['delete'])) {
	if ($_GET['delete'] == "Y") {
		$delete = true;
	}
}

if ($delete) {
	echo 'THE FOLLOWING ORPHANED FILES HAVE BEEN DELETED<br><br>';
} else {
	echo 'THE FOLLOWING ORPHANED FILES HAVE NOT BEEN DELETED<br><br>';
	echo '<a href="check_bucket_files?delete=Y">DELETE THEM NOW</a><br><br>';
}
while ($file = readdir($dir)) {
	if (!strpos($file, "-thumbnail")) {
		$filename = str_replace("'", "''", $file);
		$sql = "SELECT (SELECT count(*) FROM bento WHERE image_file_name = '$filename' OR cropped_image_file_name = '$filename' OR download_file_name = '$filename') + (SELECT count(*) from bento_files where file_name = '$filename') as count";
		$result = execute_query($sql)->fetch_object();
		if ($result->count == 0) {
			$count += 1;
			echo $file."<br>";
			if ($delete) {
				unlink($file_storage_path.$file);
			};
		}
	}
}
echo "<br><br>".$count." ORPHANED FILES FOUND.";
closedir($dir);
