<?php
$file_name = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
$content_type = null;
if ($file_name) {
    echo file_get_contents('php://input');
    $file_data = file_get_contents('php://input');
    $pos = strpos($file_data, "base64");
    if ($pos) {
        $content_type = substr($file_data, 5, $pos-6);
        $file_data =  base64_decode(substr($file_data, $pos + 7));
    }
    file_put_contents(FILE_STORAGE_PATH.$file_name, $file_data);
}
?>
