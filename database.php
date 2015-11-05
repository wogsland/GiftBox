<?php
require __DIR__.'/config.php';
if ($google_app_engine) {
    $mysqli = new mysqli(null, $user, $password, $database, null, $socket);
} else {
    if (in_array($server, array('','givetoken.local'))) {
        $mysql_server = "127.0.0.1";
    } else {
        $mysql_server = 'p:'.$server;
    }
    $mysqli = new mysqli($mysql_server, $user, $password, $database);
}
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>
