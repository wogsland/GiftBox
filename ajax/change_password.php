<?php
$message = "Unable to change password at this time.";
if (logged_in()) {
    if (isset($_POST['user_id'], $_POST['new_password'])) {
        $user = new User($_POST['user_id']);
        $user->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $user->save();
    }
    $message = "SUCCESS";
}
$json = '{"message":"'.$message.'"}';
echo $json;

?>
