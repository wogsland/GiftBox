<?php
$protocol = ($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0');
header($protocol . " 418 I'm a teapot");
$GLOBALS['http_response_code'] = 418;
echo "I'm a teapot";
