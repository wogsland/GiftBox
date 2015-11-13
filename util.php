<?php
function escape_string($string) 
{
    include __DIR__.'/database.php';
    return $mysqli->real_escape_string($string);
}

function execute_query($sql) 
{
    include __DIR__.'/database.php';
    if ($result = $mysqli->query($sql)) {
        return $result;
    } else {
        error_log($sql);
        throw new Exception($mysqli->error);
    }
}

function execute($sql) 
{
    include __DIR__.'/database.php';
    debug_output($sql);
    if (!$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception($mysqli->error);
    }
}

function insert($sql) 
{
    include __DIR__.'/database.php';
    debug_output($sql);
    if (!$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception($mysqli->error);
    }
    return $mysqli->insert_id;
}

function update($sql) 
{
    include __DIR__.'/database.php';
    debug_output($sql);
    if (!$mysqli->query($sql)) {
        error_log($sql);
        throw new Exception($mysqli->error);
    }
    return $mysqli->affected_rows;
}

function logged_in() 
{
    $logged_in = false;
    if (isset($_SESSION['user_id'])) {
        $logged_in = true;;
    }
    return $logged_in;
}

function is_admin() 
{
    $retval = false;
    if (isset($_SESSION['admin'])) {
        if ($_SESSION['admin'] == 'Y') {
            $retval = true;
        }
    }
    return $retval;
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
    include __DIR__.'/database.php';
    $session = new Zebra_Session($mysqli, 'sEcUr1tY_c0dE');
    return $session;
}
