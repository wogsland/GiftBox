<?php
use \Sizzle\EmailCredential;

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
        $$param = escape_string($_POST[$param] ?? null);
    }
    if ('' == $username) {
        $errors[] = 'Username cannot be left blank';
    }
    if ('' == $password) {
        $errors[] = 'Password cannot be left blank';
    }
    if ($smtp_host == '') {
        $errors[] = 'Invalid SMTP host';
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
