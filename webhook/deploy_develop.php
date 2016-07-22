<?php
if (ENVIRONMENT == 'development') {
    $repo = isset($_GET['repo']) ? $_GET['repo'] : 'Giftbox';
    $repos = ['Giftbox','Bacon'];
    if (in_array($repo, $repos)) {
        execute_query("UPDATE `deploy` SET `needed`='Yes' WHERE `branch`='develop' AND `repository`='{$repo}'");
    }
}
