<?php
use \Sizzle\{
    User,
    Organization
};

// collect id
$user_id = escape_string($endpoint_parts[4] ?? '');

$success = 'false';
$data = '';
if (0 < (int) $user_id) {
    $profile = execute_query(
        "SELECT user.first_name,
        user.last_name,
        user.position,
        user.linkedin,
        organization.website,
        user.about,
        user.face_image,
        organization.`name` AS organization
        FROM user
        LEFT JOIN organization ON user.organization_id = organization.id
        WHERE user.id = '$user_id'"
    )->fetch_all(MYSQLI_ASSOC);
    if (1 == count($profile)) {
        $success = 'true';
        $data = $profile[0];
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
