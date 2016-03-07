<?php
$message = "Unable to change password at this time.";
if (logged_in()) {
    $user_id = $_POST['user_id'];
    $new_password = escape_string($_POST['new_password']);
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    if ($user_id and $new_password) {
        print_r($user_id);
        print_r($new_password);
        execute("UPDATE user set password = '".$hash."' WHERE id = ".$user_id);
    }
    $message = "SUCCESS";
}
$json = '{"message":"'.$message.'"}';
echo $json;

?>
