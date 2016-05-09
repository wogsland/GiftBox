<?php
// This cron is installed on development & runs every minute
require_once __DIR__.'/config/credentials.php';
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/util.php';
$mysqli = new mysqli($mysql_server, $user, $password, $database);
new Sizzle\Bacon\Connection($mysqli);


// watch for autodeployment webhook from Github
$result = execute_query("SELECT `branch`, `repository` FROM `deploy` WHERE `needed`='Yes' AND `branch`='develop'");
while ($row = $result->fetch_assoc()) {
    $repos = ['Giftbox','Bacon'];
    if (in_array($row['repository'], $repos)) {
        exec(__DIR__.'/deploy.sh '.$row['repository']);
        execute_query("UPDATE `deploy` SET `needed`='No' WHERE `branch`='develop' AND `repository`='{$row['repository']}'");
    }
}
