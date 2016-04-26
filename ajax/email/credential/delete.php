<?php
use \Sizzle\Bacon\Database\EmailCredential;

$success = 'false';
$data = '';
if (logged_in()) {
    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];
        if ($id > 0) {
            $EmailCredential = new EmailCredential($id);
            $deleted = $EmailCredential->delete();
            if ($deleted) {
                $success = 'true';
                $data = array('id'=>$id);
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
