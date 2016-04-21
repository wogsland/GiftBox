<?php
use \Sizzle\Bacon\Database\EmailCredential;

$success = 'false';
$data = '';
$errors = [];
if (logged_in()) {
    $params = [
        'username',
        'password',
        'smtp_host',
        'smtp_port'
    ];
    foreach ($params as $param) {
        $$param = $_POST[$param] ?? null;
    }
    if (!isset($username) || '' == $username) {
        $errors[] = 'Username cannot be left blank';
    }
    if (!isset($password) || '' == $password) {
        $errors[] = 'Password cannot be left blank';
    }
    if (!isset($smtp_host) || $smtp_host == '') {
        $errors[] = 'Invalid SMTP host';
    }
    if (!isset($smtp_port) || 0 >= (int) $smtp_port) {
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
