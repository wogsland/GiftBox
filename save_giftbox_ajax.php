<?php
include_once 'util.php';

$giftbox_id = $_POST['giftbox_id'];
$giftbox_name = $_POST['name'];
$user_id = $_POST['user_id'];
$letter_text = $_POST['letter_text'];
$bentos = $_POST['bentos'];

// If no giftbox id is passed in, then INSERT a record, otherwise UPDATE the giftbox name and delete the bentos
if (!$giftbox_id) {
	$sql = "INSERT into giftbox (name, user_id, letter_text) values ('".$giftbox_name."', ".$user_id.", '".$letter_text."')";
	$giftbox_id = insert($sql);
} else {
	$sql = "UPDATE giftbox set name = '".$giftbox_name."', letter_text = '".$letter_text."' WHERE id = ".$giftbox_id;
	execute($sql);
	$sql = "DELETE FROM bento where giftbox_id = ".$giftbox_id;
	execute($sql);
}

// Insert bentos
foreach ($bentos as $bento) {
	$sql = "INSERT INTO bento (giftbox_id, css_width, css_height, css_top, css_left, image_file_name, image_width, image_height, image_top, image_left, download_file_name) VALUES (".$giftbox_id.", '".$bento['width']."', '".$bento['height']."', '".$bento['top']."', '".$bento['left']."', '".$bento['image_file_name']."', '".$bento['image_width']."', '".$bento['image_height']."', '".$bento['image_top']."', '".$bento['image_left']."', '".$bento['download_file_name']."')";
	execute($sql);
}

$return = ['giftbox_id' => $giftbox_id];
$json = json_encode($return);
header('Content-type: application/json');
echo $json;
?>