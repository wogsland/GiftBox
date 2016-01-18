<?php
use Sizzle\Connection;
require_once __DIR__.'/src/autoload.php';

function escape_string($string)
{
    return Connection::$mysqli->real_escape_string($string);
}

function execute_query($sql)
{
    if ($result = Connection::$mysqli->query($sql)) {
        return $result;
    } else {
        error_log($sql);
        throw new Exception(Connection::$mysqli->error);
    }
}

function execute($sql)
{
    debug_output($sql);
    if (!Connection::$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception(Connection::$mysqli->error);
    }
}

function insert($sql)
{
    debug_output($sql);
    if (!Connection::$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception(Connection::$mysqli->error);
    }
    return Connection::$mysqli->insert_id;
}

function update($sql)
{
    debug_output($sql);
    if (!Connection::$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception(Connection::$mysqli->error);
    }
    return Connection::$mysqli->affected_rows;
}

function logged_in()
{
    return isset($_SESSION['user_id']);
}

function is_admin()
{
    return (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Y');
}

function debug()
{
    $debug = false;
    if (isset($_SESSION['debug'])) {
        if ($_SESSION['debug'] == 'ON') {
            $debug = true;
        }
    }
    return $debug;
}

function debug_output($text)
{
    if (debug()) {
        echo "<pre>";
        foreach(debug_backtrace() as $value) {
            echo "\t";
        }
        echo $text."</pre>\n";
    }
}

function youtube_id($url)
{
    $id = null;
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $id = $match[count($match)-1];
    }
    return $id;
}

function is_youtube($url)
{
    $retval = false;
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        $retval = true;
    }
    return $retval;
}

function is_spotify($url)
{
    $retval = false;
    if (strpos($url, 'spotify.com') !== false) {
        $retval = true;
    }
    return $retval;
}

function is_soundcloud($url)
{
    $retval = false;
    if (strpos($url, 'soundcloud.com') !== false) {
        $retval = true;
    }
    return $retval;
}

function is_selected($field_value, $data_value, $select_string = 'selected')
{
    $retval = null;
    if ($field_value == $data_value) {
        $retval = $select_string;
    }
    return $retval;
}

function _session_start()
{
    $session = new Zebra_Session(Connection::$mysqli, 'sEcUr1tY_c0dE');
    return $session;
}
