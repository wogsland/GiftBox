<?php
use \GiveToken\EmailCredential;

$success = 'false';
$data = '';
if (isset($_SESSION['user_id'])) {
    $params = [
        'username',
        'password',
        'smtp_host',
        'smtp_port'
    ];
    foreach ($params as $param) {
        $$param = isset($_POST[$param]) ? escape_string($_POST[$param]) : null;
    }
    if (!filter_var($smtp_host, FILTER_VALIDATE_IP) === false
    && (int) $smtp_port == $smtp_port) {
        $user_id = $_SESSION['user_id'];
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);
        if ($id > 0) {
            $success = 'true';
            $data = array('id'=>$id);
        }
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
