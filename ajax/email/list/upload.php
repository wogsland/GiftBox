<?php
use \Sizzle\{
    EmailList,
    EmailListEmail
};

$success = 'false';
$data = '';
$fileName = escape_string($_POST['fileName'] ?? false);
$listName = escape_string($_POST['listName'] ?? false);
$localPath = $_FILES['listFile']['tmp_name'] ?? false;
if (logged_in()) {
    if ($fileName && $localPath && $listName) {
        $fileData = file_get_contents($localPath);
        $fileData = str_replace("\r\n", "\n", $fileData);
        $fileData = str_replace("\n\r", "\n", $fileData);
        $fileData = rtrim($fileData, "\n");
        $emails = explode("\n", $fileData);
        $data = array();
        $emailList = new EmailList($listName, 'name');
        if (!isset($emailList->user_id) || $emailList->user_id != $_SESSION['user_id']) {
            $emailListID = $emailList->create($_SESSION['user_id'], $listName);
            if ($emailListID > 0) {
                $data['list_id'] = $emailListID;
                $errors = array();
                $success = 'true';
                $emailListEmail = new EmailListEmail();
                $uploaded = array();
                foreach ($emails as $email) {
                    $email = strtolower($email);
                    if (!in_array($email, $uploaded)) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailListEmail->create($emailListID, $email);
                            $uploaded[] = $email;
                        } else {
                            $success = 'false';
                            $errors[] = "$email is not a valid email.";
                        }
                    } else {
                        $success = 'false';
                        $errors[] = "$email is a duplicate.";
                    }
                }
                if (!empty($errors)) {
                    $data['errors'] = $errors;
                    $data['message'] = 'There were errors processing some emails.';
                } else {
                    $data['message'] = 'Emails uploaded successfully.';
                }
            } else {
                $data['errors'][] = 'Unable to create list.';
                $data['message'] = 'Unable to create list.';
            }
        } else {
            $data['errors'][] = 'That list name is already taken.';
            $data['message'] = 'That list name is already taken.';
        }
    } else {
        $data = array(
            'errors'=>array(),
            'message'=>'There were errors processing your request.'
        );
        if (!$localPath) {
            $data['errors'][] = 'File is required.';
        }
        if (!$listName) {
            $data['errors'][] = 'List name is required.';
        }
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
