<?php
use Sizzle\Database\RecruitingCompany;

$success = 'false';
$data = '';
if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    $errors = [];
    if (isset($_POST['recruiting_company_id'])) {
        $recruiting_company_id = (int) $_POST['recruiting_company_id'];
        try {
            $RecruitingCompany = new RecruitingCompany($recruiting_company_id);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errors[] = $e->getMessage();
        }
        if ($RecruitingCompany->user_id != $user_id && !is_admin()) {
            $errors[] = 'User does not have permission to modify this company.';
        } else {
            $data = $RecruitingCompany;
        }
    } else {
        $errors[] = 'Company id required';
    }
}
header('Content-Type: application/json');
$result = array('success'=>$success, 'data'=>$data);
echo json_encode($result);
