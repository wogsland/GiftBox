<?php
// This cron is installed on development & runs every minute
require_once __DIR__.'/config/credentials.php';
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/util.php';
$mysqli = new mysqli($mysql_server, $user, $password, $database);
new Sizzle\Bacon\Connection($mysqli);


// watch for autodeployment webhook from Github
$result = execute_query("SELECT `branch` FROM `deploy` WHERE `needed`='Yes' AND `branch`='develop'");
if($row = $result->fetch_assoc()) {
    exec(__DIR__.'/deploy.sh');
    execute_query("UPDATE `deploy` SET `needed`='No' WHERE `branch`='develop'");
}
