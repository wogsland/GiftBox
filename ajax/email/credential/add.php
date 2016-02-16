<?php
use \Sizzle\EmailCredential;

$success = 'false';
$data = '';
$errors = [];
if (isset($_SESSION['user_id'])) {
    $params = [
        'username',
        'password',
        'smtp_host',
        'smtp_port'
    ];
    foreach ($params as $param) {
        $$param = escape_string($_POST[$param] ?? null);
    }
    if ('' == $username) {
        $errors[] = 'Username cannot be left blank';
    }
    if ('' == $password) {
        $errors[] = 'Password cannot be left blank';
    }
    if (filter_var($smtp_host, FILTER_VALIDATE_IP) === false) {
        $errors[] = 'Invalid IP provided for SMTP host';
    }
    if (0 >= (int) $smtp_port) {
        $errors[] = 'Invalid Port provided for SMTP host';
    }
    if (empty($errors)) {
        $user_id = $_SESSION['user_id'];
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);
        if ($id > 0) {
            $success = 'true';
            $data = array('id'=>$id);
        } else {
            $errors[] = 'Unable to insert email credentials';
        }
    }
}
if (!empty($errors)) {
    $data['errors'] = $errors;
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
