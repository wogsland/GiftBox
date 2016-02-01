<?php
// This cron is installed on development & runs every minute
require __DIR__.'/config.php';

// watch for autodeployment webhook from Github
$result = execute_query("SELECT `branch` FROM `deploy` WHERE `needed`='Yes' AND `branch`='develop'");
if($row = $result->fetch_assoc()) {
    exec(__DIR__.'/deploy.sh');
    update("UPDATE `deploy` SET `needed`='No' WHERE `branch`='develop'");
}
