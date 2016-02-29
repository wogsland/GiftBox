<?php
if (logged_in()) {
    $sql = "SELECT id, admin, first_name, last_name, email_address, location, company, position, about, username, receive_token_notifications, allow_token_responses from user where id = ".$_SESSION['user_id']." ORDER BY last_name";
    $results = execute_query($sql);
    $response = $results->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($response);
}
